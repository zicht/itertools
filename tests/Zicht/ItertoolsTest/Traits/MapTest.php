<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools\lib\MapIterator;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class MapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test without the optional $keyFunc argument for the MapIterator
     */
    public function testWithoutKeyFunc()
    {
        $valueFunc = function ($value, $key) {
            $this->assertEquals('value', $value);
            $this->assertEquals('key', $key);
            return $value;
        };

        $iterator = new MapIterator($valueFunc, new \ArrayIterator(['key' => 'value']));
        $this->assertEquals(['key'], $iterator->keys());
        $this->assertEquals(['value'], $iterator->values());
    }

    /**
     * Test with the optional $keyFunc argument for the MapIterator
     */
    public function testWithKeyFunc()
    {
        $valueFunc = function ($value, $key) {
            $this->assertEquals('value', $value);
            $this->assertEquals('key', $key);
            return $value;
        };

        $keyFunc = function ($key, $value) {
            $this->assertEquals('key', $key);
            $this->assertEquals('value', $value);
            return $key;
        };

        $iterator = new MapIterator($valueFunc, $keyFunc, new \ArrayIterator(['key' => 'value']));
        $this->assertEquals(['key'], $iterator->keys());
        $this->assertEquals(['value'], $iterator->values());
    }

    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $data, array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->map(...$arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($iterator), sizeof($expectedKeys));
        $this->assertEquals(iterator_count($iterator), sizeof($expectedKeys));
        $iterator->rewind();

        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        for ($index = 0; $index < sizeof($expectedKeys); $index++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        $addSingle = fn($a = 0) => 10 + $a;
        $addDouble = fn($a = 0, $b = 0) => 10 + $a + $b;
        $addTriple = fn($a = 0, $b = 0, $c = 0) =>10 + $a + $b + $c;

        $swapSingle = fn($first, $second) => $second;
        $swapDouble = fn($first, $second, $third, $fourth) => [$third, $fourth];

        $combineSingle = fn($first, $second) => [$first, $second];
        $combineDouble = fn($first, $second, $third, $fourth) => [$first, $second, $third, $fourth];

        return [
            // empty input
            [
                [],
                [null],
                [],
                [],
            ],

            // single iterable
            [
                [1, 2, 3],
                [$addSingle],
                [0, 1, 2],
                [11, 12, 13],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [$addSingle],
                ['a', 'b', 'c'],
                [11, 12, 13],
            ],
            [
                [1 => 1, 2 => 2, 3 => 3],
                [$addSingle],
                [1, 2, 3],
                [11, 12, 13],
            ],
            [
                [1 => 1, 'b' => 2, 3 => 3],
                [$addSingle],
                [1, 'b', 3],
                [11, 12, 13],
            ],

            // single iterable using both key and value
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [$swapSingle],
                ['a', 'b', 'c'],
                ['a', 'b', 'c'],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [$combineSingle],
                ['a', 'b', 'c'],
                [[1, 'a'], [2, 'b'], [3, 'c']],
            ],

            // multiple iterables of equal length
            [
                [1, 2, 3],
                [$addDouble, [4, 5, 6]],
                [0, 1, 2],
                [15, 17, 19],
            ],
            [
                [1, 2, 3],
                [$addTriple, [4, 5, 6], [7, 8, 9]],
                [0, 1, 2],
                [22, 25, 28],
            ],

            // multiple iterables using both keys and values
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [$swapDouble, ['d' => 4, 'e' => 5, 'f' => 6]],
                ['a:d', 'b:e', 'c:f'],
                [['a', 'd'], ['b', 'e'], ['c', 'f']],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [$combineDouble, ['d' => 4, 'e' => 5, 'f' => 6]],
                ['a:d', 'b:e', 'c:f'],
                [[1, 4, 'a', 'd'], [2, 5, 'b', 'e'], [3, 6, 'c', 'f']],
            ],

            // multiple iterables of unequal length
            [
                [1, 2],
                [$addTriple, [4, 5, 6], [7, 8, 9]],
                [0, 1],
                [22, 25],
            ],
            [
                [1, 2, 3],
                [$addTriple, [4, 5], [7, 8, 9]],
                [0, 1],
                [22, 25],
            ],
            [
                [1, 2, 3],
                [$addTriple, [4, 5, 6], [7, 8]],
                [0, 1],
                [22, 25],
            ],

            // multiple with different keys
            [
                [1 => 1, 2 => 2, 3 => 3],
                [$addDouble, [4 => 4, 5 => 5, 6 => 6]],
                ['1:4', '2:5', '3:6'],
                [15, 17, 19],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [$addDouble, [4 => 4, 5 => 5, 6 => 6]],
                ['a:4', 'b:5', 'c:6'],
                [15, 17, 19],
            ],

            // use null as value getter, this returns the value itself
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [null],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],

            // test several ways that php handles array keys *shudder*:
            // - '0' becomes 0
            // - '7 ' stays '7 '
            // - '1.0' stays '1.0'
            // - 3.0 becomes 3
            // - 4.1 becomes 4
            // - 5.5 becomes 5
            // - 6.9 becomes 6
            [
                ['0' => 1, 'b' => 2, 3.0 => 3, 'D' => 4, '1.0' => 5, 4.1 => 6, 5.5 => 7, 6.9 => 8, '7 ' => 9],
                [$addDouble, [0 => 1, 'b' => 2, '3' => 3, 'd' => 4, 1 => 5, '4.1' => 6, 5 => 7, 6 => 8, 7 => 9]],
                [0, 'b', 3, 'D:d', '1.0:1', '4:4.1', 5, 6, '7 :7'],
                [12, 14, 16, 18, 20, 22, 24, 26, 28],
            ],
        ];
    }

//    /**
//     * @param mixed $closure
//     * @param mixed $iterable
//     * @expectedException \InvalidArgumentException
//     * @dataProvider badArgumentProvider
//     */
//    public function testBadArgumentsToFunction($closure, $iterable)
//    {
//        call_user_func_array('\Zicht\Itertools\map', [$closure, $iterable]);
//    }
//
//    /**
//     * @expectedException \InvalidArgumentException
//     */
//    public function testBadArgumentToIterator()
//    {
//        new MapIterator(
//            function () {
//            },
//            123
//        );
//    }
//
//    /**
//     * Provides bad sequence tests
//     *
//     * @return array
//     */
//    public function badArgumentProvider()
//    {
//        return [
//            [123, [1, 2, 3]],
//            [true, [1, 2, 3]],
//        ];
//    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\MapIterator', $iterable->map(null));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->map(null));
    }
}
