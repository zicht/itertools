<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\BadToArrayObject;

/**
 * Class ToArrayTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test good sequences
     *
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
