<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class SelectTest
 *
 * @package Zicht\ItertoolsTest
 */
class SelectTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test good sequences
     *
     * @param mixed $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($data, array $expected)
    {
        $this->assertEquals($expected, iter\select(null, $data));
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [
                [1, 2, 3],
                [1, 2, 3]
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [1, 2, 3]
            ],
            // duplicate keys
            [
                iter\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                [-1, -2, -3, 1, 2, 3]
            ],
        ];
    }
}
