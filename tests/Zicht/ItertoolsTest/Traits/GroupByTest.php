<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\Itertools\mappings;
use Zicht\ItertoolsTest\Dummies\NonIterator;

class GroupByTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
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
        $list = Itertools\iterable([1, 2, 3, 1, 2, 3]);
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
        $list = Itertools\iterable(['A' => Itertools\iterable(['a' => 1, 'b' => 2, 'c' => 3]), 'B' => Itertools\iterable(['d' => 4, 'e' => 5, 'f' => 6])]);
        $expected = [
            'A' => [
                'A' => ['a' => 1, 'b' => 2, 'c' => 3],
            ],
            'B' => [
                'B' => ['d' => 4, 'e' => 5, 'f' => 6],
            ],
        ];
        $this->assertEquals($expected, $list->groupBy(mappings\key())->toArray());
    }

    /**
     * Test that values also converts the GroupedItems into values
     */
    public function testValues()
    {
        $list = Itertools\iterable([1, 2, 3, 1, 2, 3]);
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
        $list = Itertools\iterable(['A' => Itertools\iterable([1, 2, 3]), 'B' => Itertools\iterable([4, 5, 6])]);
        $expected = [
            [
                [1, 2, 3],
            ],
            [
                [4, 5, 6],
            ],
        ];
        $this->assertEquals($expected, $list->groupBy(mappings\key())->values());
    }

    /**
     * Test that groupBy can compare array values when determining if something is part of a group.
     */
    public function testUseArrayToGroupBy()
    {
        $list = Itertools\iterable(
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

        $grouped = $list->groupBy(mappings\select(['foo', 'bar']));
        $this->assertEquals($expectedKeys, $grouped->keys());
        $this->assertEquals($expectedValues, $grouped->values());
    }
}
