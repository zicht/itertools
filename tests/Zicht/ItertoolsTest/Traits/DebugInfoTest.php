<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;

class DebugInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test __debugInfo
     */
    public function testSimple()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
        $expected = [
            '__length__' => 3,
            0 => 1,
            1 => 2,
            2 => 3,
        ];
        $this->assertEquals($expected, $iterable->__debugInfo());
    }

    /**
     * Test __debugInfo with duplicate keys
     */
    public function testDuplicateKeys()
    {
        $iterable = Itertools\iterable([1, 2, 3])->chain([4, 5, 6]);
        $expected = [
            '__length__' => 6,
            0 => 1,
            1 => 2,
            2 => 3,
            '0__#1__' => 4,
            '1__#1__' => 5,
            '2__#1__' => 6,
        ];
        $this->assertEquals($expected, $iterable->__debugInfo());
    }
}
