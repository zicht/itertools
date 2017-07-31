<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\Itertools\mappings;
use Zicht\ItertoolsTest\Dummies\NonIterator;

/**
 * Class GroupByTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
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
     * Test that groupBy can compare array values when determining is something is part of a group
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
