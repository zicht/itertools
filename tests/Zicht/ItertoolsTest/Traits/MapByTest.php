<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\ItertoolsTest\Dummies\NonIterator;
use Zicht\ItertoolsTest\Dummies\SimpleObject;
use function Zicht\Itertools\iterable;

class MapByTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $data, array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->mapBy(...$arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapByIterator', $iterator);
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
     * Provides tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        $addClosure = fn($a) => $a + 10;

        $incrementKey = fn($value, $key) => $key + 1;

        return [
            // callback
            [
                [1, 2, 3],
                [$addClosure],
                [11, 12, 13],
                [1, 2, 3],
            ],
            // duplicate keys
            [
                [1, 2, 3, 3, 1, 2],
                [$addClosure],
                [11, 12, 13, 13, 11, 12],
                [1, 2, 3, 3, 1, 2],
            ],
            // use string to identify array key
            [
                [['key' => 'k1'], ['key' => 'k2'], ['key' => 'k3']],
                ['key'],
                ['k1', 'k2', 'k3'],
                [['key' => 'k1'], ['key' => 'k2'], ['key' => 'k3']],
            ],
            [
                [['key' => 1], ['key' => 2], ['key' => 3]],
                ['key'],
                [1, 2, 3],
                [['key' => 1], ['key' => 2], ['key' => 3]],
            ],
            // use string to identify object property
            [
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')],
                ['prop'],
                ['p1', 'p2', 'p3'],
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')],
            ],
            [
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)],
                ['prop'],
                [1, 2, 3],
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)],
            ],
            // use string to identify object get method
            [
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')],
                ['getProp'],
                ['p1', 'p2', 'p3'],
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')],
            ],
            [
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)],
                ['getProp'],
                [1, 2, 3],
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)],
            ],
            // use null as value getter, this returns the value itself
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [null],
                [1, 2, 3],
                [1, 2, 3],
            ],
            // the closure is given both $value and $key as parameters
            [
                [0 => 'a', 1 => 'b', 2 => 'c'],
                [$incrementKey],
                [1, 2, 3],
                ['a', 'b', 'c'],
            ],
        ];
    }

    /**
     * Test mapBy using invalid arguments
     *
     * @expectedException \Error
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        iterable([1, 2, 3])->mapBy(...$arguments);
    }

    /**
     * Provides invalid tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[123]],
            [[true]],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\MapByIterator', $iterable->mapBy(null));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->mapBy(null));
    }
}
