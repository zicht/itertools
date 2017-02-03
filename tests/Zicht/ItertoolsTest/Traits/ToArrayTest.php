<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools as iter;

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
                iter\iterable([1, 2, 3]),
                [1, 2, 3],
            ],
            [
                iter\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                ['a' => 1, 'b' => 2, 'c' => 3],
            ],
            // duplicate keys
            [
                iter\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                ['a' => 1, 'b' => 2, 'c' => 3],
            ],
        ];
    }
}
