<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools as iter;

/**
 * Class DebugInfoTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class DebugInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test __debugInfo
     */
    public function testSimple()
    {
        $result = iter\iterable([1, 2, 3])->__debugInfo();
        $expected = [
            '__length__' => 3,
            0 => 1,
            1 => 2,
            2 => 3,
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test __debugInfo with duplicate keys
     */
    public function testDuplicateKeys()
    {
        $result = iter\iterable([1, 2, 3])->chain([4, 5, 6])->__debugInfo();
        $expected = [
            '__length__' => 6,
            0 => 1,
            1 => 2,
            2 => 3,
            '0__#1__' => 4,
            '1__#1__' => 5,
            '2__#1__' => 6,
        ];
        $this->assertEquals($expected, $result);
    }
}
