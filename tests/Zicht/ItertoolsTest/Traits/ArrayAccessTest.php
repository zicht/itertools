<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\NonIterator;

class ArrayAccessTest extends TestCase
{
    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator[42]);
    }

    public function testOffsetExists()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
        $this->assertTrue($iterable->offsetExists(0));
        $this->assertTrue($iterable->offsetExists(1));
        $this->assertTrue($iterable->offsetExists(2));
        $this->assertNotTrue($iterable->offsetExists(-1));
        $this->assertNotTrue($iterable->offsetExists(3));
    }

    public function testOffsetGet()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
        $this->assertEquals(1, $iterable->offsetGet(0));
        $this->assertEquals(2, $iterable->offsetGet(1));
        $this->assertEquals(3, $iterable->offsetGet(2));
        $this->assertEquals(1, $iterable[0]);
        $this->assertEquals(2, $iterable[1]);
        $this->assertEquals(3, $iterable[2]);
        $this->assertEquals(null, $iterable->offsetGet(-1));
        $this->assertEquals(null, $iterable->offsetGet(3));
        $this->assertEquals('default', $iterable->offsetGet(-1, 'default'));
        $this->assertEquals('default', $iterable->offsetGet(3, 'default'));
    }

    public function testOffsetSet()
    {
        $this->expectException(\RuntimeException::class);
        $iterable = Itertools\iterable([1, 2, 3]);
        $iterable->offsetSet(0, 1);
    }

    public function testOffsetUnset()
    {
        $this->expectException(\RuntimeException::class);
        $iterable = Itertools\iterable([1, 2, 3]);
        $iterable->offsetUnset(0);
    }
}
