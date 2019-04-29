<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;
use Zicht\Itertools\lib\GroupedIterator;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

class GroupByTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test what happens when grouping without sorting the input
     */
    public function testUnsorted()
    {
        $obj = function ($property, $title) {
            return (object)['prop' => $property, 'title' => $title];
        };

        $list = [$obj('1group', '1A'), $obj('1group', '1B'), $obj('2group', '2A'), $obj('2group', '2B'), $obj('1group', '1C')];

        $iterator = Itertools\groupby('prop', $list, false);
        $this->assertInstanceOf('\Zicht\Itertools\lib\GroupbyIterator', $iterator);
        $iterator->rewind();

        $this->assertTrue($iterator->valid());
        $this->assertEquals('1group', $iterator->key());
        $groupedIterator = $iterator->current();
        $this->assertInstanceOf('\Zicht\Itertools\lib\GroupedIterator', $groupedIterator);
        $groupedIterator->rewind();
        $this->assertTrue($groupedIterator->valid());
        $this->assertEquals(0, $groupedIterator->key());
        $this->assertEquals($obj('1group', '1A'), $groupedIterator->current());
        $groupedIterator->next();
        $this->assertTrue($groupedIterator->valid());
        $this->assertEquals(1, $groupedIterator->key());
        $this->assertEquals($obj('1group', '1B'), $groupedIterator->current());
        $groupedIterator->next();
        $this->assertFalse($groupedIterator->valid());
        $iterator->next();

        $this->assertTrue($iterator->valid());
        $this->assertEquals('2group', $iterator->key());
        $groupedIterator = $iterator->current();
        $this->assertInstanceOf('\Zicht\Itertools\lib\GroupedIterator', $groupedIterator);
        $groupedIterator->rewind();
        $this->assertTrue($groupedIterator->valid());
        $this->assertEquals(2, $groupedIterator->key());
        $this->assertEquals($obj('2group', '2A'), $groupedIterator->current());
        $groupedIterator->next();
        $this->assertTrue($groupedIterator->valid());
        $this->assertEquals(3, $groupedIterator->key());
        $this->assertEquals($obj('2group', '2B'), $groupedIterator->current());
        $groupedIterator->next();
        $this->assertFalse($groupedIterator->valid());
        $iterator->next();

        // now this is the repeating key, that *will conflict* when
        // using iterator_to_array($iterator, true)
        $this->assertTrue($iterator->valid());
        $this->assertEquals('1group', $iterator->key());
        $groupedIterator = $iterator->current();
        $this->assertInstanceOf('\Zicht\Itertools\lib\GroupedIterator', $groupedIterator);
        $groupedIterator->rewind();
        $this->assertTrue($groupedIterator->valid());
        $this->assertEquals(4, $groupedIterator->key());
        $this->assertEquals($obj('1group', '1C'), $groupedIterator->current());
        $groupedIterator->next();
        $this->assertFalse($groupedIterator->valid());
        $iterator->next();

        // nothing left in the iterator
        $this->assertFalse($iterator->valid());
    }

    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\groupby', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\GroupbyIterator', $iterator);
        $this->assertEquals(sizeof($iterator), sizeof($expected));
        $this->assertEquals(iterator_count($iterator), sizeof($expected));
        $iterator->rewind();

        foreach ($expected as $key => $expectedGroup) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            /** @var GroupedIterator $groupedIterator */
            $groupedIterator = $iterator->current();
            $this->assertInstanceOf('\Zicht\Itertools\lib\GroupedIterator', $groupedIterator);
            $this->assertEquals(sizeof($groupedIterator), sizeof($expectedGroup));
            $this->assertEquals(iterator_count($groupedIterator), sizeof($expectedGroup));
            $groupedIterator->rewind();

            foreach ($expectedGroup as $groupKey => $groupValue) {
                $this->assertTrue($groupedIterator->valid(), 'Failure in $groupedIterator->valid()');
                $this->assertEquals($groupKey, $groupedIterator->key(), 'Failure in $groupedIterator->key()');
                $this->assertEquals($groupValue, $groupedIterator->current(), 'Failure in $groupedIterator->current()');
                $groupedIterator->next();
            }
            $this->assertFalse($groupedIterator->valid());

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
        return [
            // callback
            [
                [
                    function ($a) {
                        return $a + 10;
                    }, [1, 2, 2, 3, 3, 3], false,
                ],
                [11 => [0 => 1], 12 => [1 => 2, 2 => 2], 13 => [3 => 3, 4 => 3, 5 => 3]],
            ],

            // callback using auto-sort
            [
                [
                    function ($a) {
                        return $a + 10;
                    }, [3, 2, 1, 2, 3, 3], true,
                ],
                [11 => [2 => 1], 12 => [1 => 2, 3 => 2], 13 => [0 => 3, 4 => 3, 5 => 3]],
            ],
            [
                [
                    function ($a) {
                        return $a + 10;
                    }, [3, 2, 1, 2, 3, 3],
                ],
                [11 => [2 => 1], 12 => [1 => 2, 3 => 2], 13 => [0 => 3, 4 => 3, 5 => 3]],
            ],

            // use string to identify array key
            [
                ['key', [['key' => 'k1'], ['key' => 'k2'], ['key' => 'k2']]],
                ['k1' => [0 => ['key' => 'k1']], 'k2' => [1 => ['key' => 'k2'], 2 => ['key' => 'k2']]],
            ],
            [
                ['key', [['key' => 1], ['key' => 2], ['key' => 2]], false],
                [1 => [0 => ['key' => 1]], 2 => [1 => ['key' => 2], 2 => ['key' => 2]]],
            ],

            // use string to identify object property
            [
                ['prop', [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p2')]],
                ['p1' => [0 => new SimpleObject('p1')], 'p2' => [1 => new SimpleObject('p2'), 2 => new SimpleObject('p2')]],
            ],
            [
                ['prop', [new SimpleObject(1), new SimpleObject(2), new SimpleObject(2)]],
                [1 => [0 => new SimpleObject(1)], 2 => [1 => new SimpleObject(2), 2 => new SimpleObject(2)]],
            ],

            // use string to identify object get method
            [
                ['getProp', [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p2')]],
                ['p1' => [0 => new SimpleObject('p1')], 'p2' => [1 => new SimpleObject('p2'), 2 => new SimpleObject('p2')]],
            ],
            [
                ['getProp', [new SimpleObject(1), new SimpleObject(2), new SimpleObject(2)]],
                [1 => [0 => new SimpleObject(1)], 2 => [1 => new SimpleObject(2), 2 => new SimpleObject(2)]],
            ],

            // use null as value getter, this returns the value itself
            [
                [null, ['a' => 1, 'b' => 2, 'c' => 1]],
                [1 => ['a' => 1, 'c' => 1], 2 => ['b' => 2]],
            ],

            // the callback should contain both the key (2nd parameter) and the value (1st parameter)
            [
                [
                    function ($value, $key) {
                        return $key;
                    }, ['c' => 1, 'b' => 2, 'a' => 3],
                ],
                ['a' => ['a' => 3], 'b' => ['b' => 2], 'c' => ['c' => 1]],
            ],
        ];
    }

    public function testToArray()
    {
        $iterable = Itertools\iterable([0 => 1, 1 => 2, 2 => 3, 3 => 2, 4 => 3, 5 => 3]);
        $grouped = $iterable->groupBy(null);
        $this->assertEquals([1 => [0 => 1], 2 => [1 => 2, 3 => 2], 3 => [2 => 3, 4 => 3, 5 => 3]], $grouped->toArray());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\groupby', $arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [['foo', [1, 2, 3], 'not-a-boolean']],
            [[123, [1, 2, 3]]],
            [[true, [1, 2, 3]]],
        ];
    }
}
