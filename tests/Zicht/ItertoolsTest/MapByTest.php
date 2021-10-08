<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\ItertoolsTest\Dummies\SimpleObject;

class MapByTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\mapBy', $arguments);
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
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testDeprecatedKeyCallback(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\keyCallback', $arguments);
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
        $addClosure = function ($a) {
            return $a + 10;
        };

        $incrementKey = function ($value, $key) {
            return $key + 1;
        };

        return [
            // callback
            [
                [$addClosure, [1, 2, 3]],
                [11, 12, 13],
                [1, 2, 3],
            ],
            // duplicate keys
            [
                [$addClosure, [1, 2, 3, 3, 1, 2]],
                [11, 12, 13, 13, 11, 12],
                [1, 2, 3, 3, 1, 2],
            ],
            // use string to identify array key
            [
                ['key', [['key' => 'k1'], ['key' => 'k2'], ['key' => 'k3']]],
                ['k1', 'k2', 'k3'],
                [['key' => 'k1'], ['key' => 'k2'], ['key' => 'k3']],
            ],
            [
                ['key', [['key' => 1], ['key' => 2], ['key' => 3]]],
                [1, 2, 3],
                [['key' => 1], ['key' => 2], ['key' => 3]],
            ],
            // use string to identify object property
            [
                ['prop', [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')]],
                ['p1', 'p2', 'p3'],
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')],
            ],
            [
                ['prop', [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)]],
                [1, 2, 3],
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)],
            ],
            // use string to identify object get method
            [
                ['getProp', [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')]],
                ['p1', 'p2', 'p3'],
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')],
            ],
            [
                ['getProp', [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)]],
                [1, 2, 3],
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)],
            ],
            // use null as value getter, this returns the value itself
            [
                [null, ['a' => 1, 'b' => 2, 'c' => 3]],
                [1, 2, 3],
                [1, 2, 3],
            ],
            // the closure is given both $value and $key as parameters
            [
                [$incrementKey, [0 => 'a', 1 => 'b', 2 => 'c']],
                [1, 2, 3],
                ['a', 'b', 'c'],
            ],
        ];
    }

    /**
     * Test mapBy using invalid arguments
     *
     * @param array $arguments
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\mapBy', $arguments);
    }

    /**
     * Provides invalid tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[123, [1, 2, 3]]],
            [[true, [1, 2, 3]]],
        ];
    }
}
