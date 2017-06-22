<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use Zicht\Itertools\filters;

/**
 * Class NotTest
 *
 * @package Zicht\ItertoolsTest\filters
 */
class NotTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple not equals test
     */
    public function test()
    {
        $filter = filters\not(filters\equals('a'));
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('b'));
        $this->assertFalse($filter('a'));
    }

    /**
     * The closure must propagate the key to the strategy
     */
    public function testKeyPropagation()
    {
        $strategy = function ($value, $key) {
            $this->assertEquals('a', $value);
            $this->assertEquals('key', $key);
            return $value;
        };

        $filter = filters\not(filters\equals('a', $strategy));
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter('a', 'key'));
    }
}
