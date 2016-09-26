<?php

namespace Zicht\ItertoolsTest\filters;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools\filters;

class InTest extends PHPUnit_Framework_TestCase
{
    /**
     * Simple instanceof test
     */
    public function test()
    {
        $filter = filters\in(['a', 'b', 'c']);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('b'));
        $this->assertFalse($filter('e'));
    }

    /**
     * Instanceof test with a specific property
     */
    public function testProperty()
    {
        $filter = filters\in(['a', 'b', 'c'], 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(['prop' => 'b']));
        $this->assertFalse($filter(['hello world']));
        $this->assertFalse($filter(['prop' => 'Hello world']));
    }
}
