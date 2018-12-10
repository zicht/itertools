<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\BadToArrayObject;

class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expected)
    {
        $this->assertEquals($expected, $iterable->toArray());
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [
                Itertools\iterable([1, 2, 3]),
                [1, 2, 3],
            ],
            [
                Itertools\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                ['a' => 1, 'b' => 2, 'c' => 3],
            ],
            // duplicate keys
            [
                Itertools\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                ['a' => 1, 'b' => 2, 'c' => 3],
            ],
            // calling values is recursive
            [
                Itertools\iterable(['A' => Itertools\iterable(['a' => 1, 'b' => 2, 'c' => 3]), 'B' => Itertools\iterable(['d' => 4, 'e' => 5, 'f' => 6])]),
                ['A' => ['a' => 1, 'b' => 2, 'c' => 3], 'B' => ['d' => 4, 'e' => 5, 'f' => 6]],
            ],
        ];
    }

    /**
     * Test that toArray returns an empty array when the trait is applied on a non-Traversable
     */
    public function testNonTraversable()
    {
        $object = new BadToArrayObject();
        $this->assertEquals([], $object->toArray());
    }
}
