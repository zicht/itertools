<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools;

class DebugInfoTest extends TestCase
{
    /**
     * @requires PHP < 8
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
     * @requires PHP < 8
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
