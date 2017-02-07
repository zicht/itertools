<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools as iter;

/**
 * Class GetterTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class GetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test has
     */
    public function testHas()
    {
        $iterable = iter\iterable([1, 2, 3]);
        $this->assertTrue($iterable->has(0));
        $this->assertTrue($iterable->has(1));
        $this->assertTrue($iterable->has(2));
        $this->assertNotTrue($iterable->has(-1));
        $this->assertNotTrue($iterable->has(3));
    }

    /**
     * Test get
     */
    public function testGet()
    {
        $iterable = iter\iterable([1, 2, 3]);
        $this->assertEquals(1, $iterable->get(0));
        $this->assertEquals(2, $iterable->get(1));
        $this->assertEquals(3, $iterable->get(2));
        $this->assertEquals(null, $iterable->get(-1));
        $this->assertEquals(null, $iterable->get(3));
        $this->assertEquals('default', $iterable->get(-1, 'default'));
        $this->assertEquals('default', $iterable->get(3, 'default'));
    }
}
