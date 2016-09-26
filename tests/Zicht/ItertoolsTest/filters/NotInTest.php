<?php

namespace Zicht\ItertoolsTest\filters;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools\filters;

class NotInTest extends PHPUnit_Framework_TestCase
{
    /**
     * Simple instanceof test
     */
    public function test()
    {
        $filter = filters\not_in(['a', 'b', 'c']);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter('b'));
        $this->assertTrue($filter('e'));
    }

    /**
     * Instanceof test with a specific property
     */
    public function testProperty()
    {
        $filter = filters\not_in(['a', 'b', 'c'], 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter(['prop' => 'b']));
        $this->assertTrue($filter(['hello world']));
        $this->assertTrue($filter(['prop' => 'Hello world']));
    }
}
