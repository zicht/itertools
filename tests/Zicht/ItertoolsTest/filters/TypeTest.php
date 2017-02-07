<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use Zicht\Itertools\filters;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

/**
 * Class TypeTest
 *
 * @package Zicht\ItertoolsTest\filters
 */
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
}
