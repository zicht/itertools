<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use Zicht\Itertools\filters;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

class TypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple instanceof test
     */
    public function test()
    {
        $filter = filters\type('Zicht\ItertoolsTest\Dummies\SimpleObject');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(new SimpleObject('test')));
        $this->assertFalse($filter('Hello world'));
    }

    /**
     * Instanceof test with a specific property
     */
    public function testProperty()
    {
        $filter = filters\type('\Zicht\ItertoolsTest\Dummies\SimpleObject', 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(['prop' => new SimpleObject('test')]));
        $this->assertFalse($filter('Hello world'));
        $this->assertFalse($filter(['prop' => 'Hello world']));
    }

    /**
     * The closure must propagate the key to the strategy
     */
    public function testKeyPropagation()
    {
        $strategy = function ($value, $key) {
            $this->assertInstanceOf('Zicht\ItertoolsTest\Dummies\SimpleObject', $value);
            $this->assertEquals('test', $value->prop);
            $this->assertEquals('key', $key);
            return $value;
        };

        $filter = filters\type('Zicht\ItertoolsTest\Dummies\SimpleObject', $strategy);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(new SimpleObject('test'), 'key'));
    }
}
