<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class KeysTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class KeysTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($expected, $iterable->keys());
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [
                iter\iterable([1, 2, 3]),
                [0, 1, 2]
            ],
            [
                iter\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                ['a', 'b', 'c']
            ],
            // duplicate keys
            [
                iter\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                ['a', 'b', 'c', 'a', 'b', 'c']
            ],
        ];
    }
}
