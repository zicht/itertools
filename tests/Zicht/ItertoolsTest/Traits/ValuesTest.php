<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;

/**
 * Class ValuesTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class ValuesTest extends \PHPUnit_Framework_TestCase
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
        $this->assertEquals($expected, $iterable->values());
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
                [1, 2, 3],
            ],
            // duplicate keys
            [
                Itertools\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                [-1, -2, -3, 1, 2, 3],
            ],
            // calling values is recursive
            [
                Itertools\iterable([Itertools\iterable([1, 2, 3]), Itertools\iterable([4, 5, 6])]),
                [[1, 2, 3], [4, 5, 6]],
            ],
        ];
    }
}
