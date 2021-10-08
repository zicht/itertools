<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;

class GetterTest extends \PHPUnit_Framework_TestCase
{
    public function testHas()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
        $this->assertTrue($iterable->has(0));
        $this->assertTrue($iterable->has(1));
        $this->assertTrue($iterable->has(2));
        $this->assertNotTrue($iterable->has(-1));
        $this->assertNotTrue($iterable->has(3));
    }

    public function testGet()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
        $this->assertEquals(1, $iterable->get(0));
        $this->assertEquals(2, $iterable->get(1));
        $this->assertEquals(3, $iterable->get(2));
        $this->assertEquals(null, $iterable->get(-1));
        $this->assertEquals(null, $iterable->get(3));
        $this->assertEquals('default', $iterable->get(-1, 'default'));
        $this->assertEquals('default', $iterable->get(3, 'default'));
    }
}
