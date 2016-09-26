<?php

namespace Zicht\ItertoolsTest\filters;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools\filters;

class Foo
{
}

class TypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Simple instanceof test
     */
    public function test()
    {
        $filter = filters\type('\Zicht\ItertoolsTest\filters\Foo');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(new Foo()));
        $this->assertFalse($filter('Hello world'));
    }

    /**
     * Instanceof test with a specific property
     */
    public function testProperty()
    {
        $filter = filters\type('\Zicht\ItertoolsTest\filters\Foo', 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(['prop' => new Foo()]));
        $this->assertFalse($filter('Hello world'));
        $this->assertFalse($filter(['prop' => 'Hello world']));
    }
}
