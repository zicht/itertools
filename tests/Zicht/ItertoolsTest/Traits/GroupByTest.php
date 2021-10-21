<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\lib\GroupedIterator;
use Zicht\Itertools\util\Mappings;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use Zicht\ItertoolsTest\Dummies\SimpleObject;
use function Zicht\Itertools\iterable;

class GroupByTest extends TestCase
{
    /**
     * Test what happens when grouping without sorting the input
     */
    public function testUnsorted()
    {
        $obj = fn($property, $title) => (object)['prop' => $property, 'title' => $title];

        $list = [
            $obj('1group', '1A'),
            $obj('1group', '1B'),
            $obj('2group', '2A'),
            $obj('2group', '2B'),
            $obj('1group', '1C'),
        ];

        $iterator = iterable($list)->groupBy('prop', false);
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
    public function testGoodSequence(array $data, array $arguments, array $expected)
    {
        $iterator = iterable($data)->groupBy(...$arguments);
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
                [1, 2, 2, 3, 3, 3],
                [
                    fn($a) => $a + 10,
                    false,
                ],
                [11 => [0 => 1], 12 => [1 => 2, 2 => 2], 13 => [3 => 3, 4 => 3, 5 => 3]],
            ],

            // callback using auto-sort
            [
                [3, 2, 1, 2, 3, 3],
                [
                    fn($a) => $a + 10,
                    true,
                ],
                [11 => [2 => 1], 12 => [1 => 2, 3 => 2], 13 => [0 => 3, 4 => 3, 5 => 3]],
            ],
            [
                [3, 2, 1, 2, 3, 3],
                [
                    fn($a) => $a + 10,
                ],
                [11 => [2 => 1], 12 => [1 => 2, 3 => 2], 13 => [0 => 3, 4 => 3, 5 => 3]],
            ],

            // use string to identify array key
            [
                [['key' => 'k1'], ['key' => 'k2'], ['key' => 'k2']],
                ['key'],
                ['k1' => [0 => ['key' => 'k1']], 'k2' => [1 => ['key' => 'k2'], 2 => ['key' => 'k2']]],
            ],
            [
                [['key' => 1], ['key' => 2], ['key' => 2]],
                ['key', false],
                [1 => [0 => ['key' => 1]], 2 => [1 => ['key' => 2], 2 => ['key' => 2]]],
            ],

            // use string to identify object property
            [
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p2')],
                ['prop'],
                ['p1' => [0 => new SimpleObject('p1')], 'p2' => [1 => new SimpleObject('p2'), 2 => new SimpleObject('p2')]],
            ],
            [
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(2)],
                ['prop'],
                [1 => [0 => new SimpleObject(1)], 2 => [1 => new SimpleObject(2), 2 => new SimpleObject(2)]],
            ],

            // use string to identify object get method
            [
                [new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p2')],
                ['getProp'],
                ['p1' => [0 => new SimpleObject('p1')], 'p2' => [1 => new SimpleObject('p2'), 2 => new SimpleObject('p2')]],
            ],
            [
                [new SimpleObject(1), new SimpleObject(2), new SimpleObject(2)],
                ['getProp'],
                [1 => [0 => new SimpleObject(1)], 2 => [1 => new SimpleObject(2), 2 => new SimpleObject(2)]],
            ],

            // use null as value getter, this returns the value itself
            [
                ['a' => 1, 'b' => 2, 'c' => 1],
                [null],
                [1 => ['a' => 1, 'c' => 1], 2 => ['b' => 2]],
            ],

            // the callback should contain both the key (2nd parameter) and the value (1st parameter)
            [
                ['c' => 1, 'b' => 2, 'a' => 3],
                [
                    fn($value, $key) => $key,
                ],
                ['a' => ['a' => 3], 'b' => ['b' => 2], 'c' => ['c' => 1]],
            ],
        ];
    }

    /**
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $this->expectException(\Error::class);
        iterable([1, 2, 3])->groupBy(...$arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[123]],
            [[true]],

            // Because we are now using `bool $sort` type annotation, string parameters are converted to a boolean.  Thanks php...
            // [[null, 'this is not a boolean']],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\GroupByIterator', $iterable->groupBy(null));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->groupBy(null));
    }

    /**
     * Test that toArray also converts the GroupedItems into arrays
     */
    public function testToArray()
    {
        $list = iterable([1, 2, 3, 1, 2, 3]);
        $expected = [
            1 => [0 => 1, 3 => 1],
            2 => [1 => 2, 4 => 2],
            3 => [2 => 3, 5 => 3],
        ];
        $this->assertEquals($expected, $list->groupBy(null)->toArray());
    }

    /**
     * Test that toArray also converts the GroupedItems into arrays
     */
    public function testToArrayRecursively()
    {
        $list = iterable(['A' => iterable(['a' => 1, 'b' => 2, 'c' => 3]), 'B' => iterable(['d' => 4, 'e' => 5, 'f' => 6])]);
        $expected = [
            'A' => [
                'A' => ['a' => 1, 'b' => 2, 'c' => 3],
            ],
            'B' => [
                'B' => ['d' => 4, 'e' => 5, 'f' => 6],
            ],
        ];
        $this->assertEquals($expected, $list->groupBy(Mappings::key())->toArray());
    }

    /**
     * Test that values also converts the GroupedItems into values
     */
    public function testValues()
    {
        $list = iterable([1, 2, 3, 1, 2, 3]);
        $expected = [
            [0 => 1, 1 => 1],
            [0 => 2, 1 => 2],
            [0 => 3, 1 => 3],
        ];
        $this->assertEquals($expected, $list->groupBy(null)->values());
    }

    /**
     * Test that values also converts the GroupedItems into values (recursively)
     */
    public function testValuesRecursively()
    {
        $list = iterable(['A' => iterable([1, 2, 3]), 'B' => iterable([4, 5, 6])]);
        $expected = [
            [
                [1, 2, 3],
            ],
            [
                [4, 5, 6],
            ],
        ];
        $this->assertEquals($expected, $list->groupBy(Mappings::key())->values());
    }

    /**
     * Test that groupBy can compare array values when determining if something is part of a group.
     */
    public function testUseArrayToGroupBy()
    {
        $list = iterable(
            [
                ['a' => 'a', 'foo' => 'foo', 'bar' => 'bar'],
                ['b' => 'b', 'foo' => 'foo', 'bar' => 'not-bar'],
                ['c' => 'c', 'foo' => 'foo', 'bar' => 'BAR-capitalized'],
                ['d' => 'd', 'foo' => 'foo', 'bar' => 'bar'],
                ['e' => 'e', 'foo' => 'foo', 'bar' => 'BAR-capitalized'],
            ]
        );

        // the order of the elements is based on ASCII sorting, done by groupBy
        $expectedKeys = [
            ['foo', 'BAR-capitalized'],
            ['foo', 'bar'],
            ['foo', 'not-bar'],
        ];
        $expectedValues = [
            [
                ['c' => 'c', 'foo' => 'foo', 'bar' => 'BAR-capitalized'],
                ['e' => 'e', 'foo' => 'foo', 'bar' => 'BAR-capitalized'],
            ],
            [
                ['a' => 'a', 'foo' => 'foo', 'bar' => 'bar'],
                ['d' => 'd', 'foo' => 'foo', 'bar' => 'bar'],
            ],
            [
                ['b' => 'b', 'foo' => 'foo', 'bar' => 'not-bar'],
            ],
        ];

        $grouped = $list->groupBy(Mappings::select(['foo', 'bar']));
        $this->assertEquals($expectedKeys, $grouped->keys());
        $this->assertEquals($expectedValues, $grouped->values());
    }
}
