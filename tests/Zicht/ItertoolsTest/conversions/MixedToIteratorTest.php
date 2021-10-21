<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\conversions;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Conversions;
use Zicht\ItertoolsTest\Dummies\DummyTraversable;

class MixedToIteratorTest extends TestCase
{
    /**
     * Test NULL input
     */
    public function testNull()
    {
        $result = Conversions::mixedToIterator(null);
        $this->assertEquals([], iterator_to_array($result));
    }

    /**
     * Test array input
     */
    public function testArray()
    {
        $result = Conversions::mixedToIterator([1, 2, 3]);
        $this->assertEquals([1, 2, 3], iterator_to_array($result));
    }

    /**
     * Test string input
     */
    public function testString()
    {
        $result = Conversions::mixedToIterator('Foo');
        $this->assertEquals(['F', 'o', 'o'], iterator_to_array($result));
    }

    /**
     * Test doctrine Collection input
     */
    public function testCollection()
    {
        $result = Conversions::mixedToIterator(new ArrayCollection([1, 2, 3]));
        $this->assertEquals([1, 2, 3], iterator_to_array($result));
    }

    /**
     * Test Traversable input
     */
    public function testTraversable()
    {
        $result = Conversions::mixedToIterator(new DummyTraversable([1, 2, 3]));
        $this->assertEquals([1, 2, 3], iterator_to_array($result));
    }

    /**
     * Test Iterator input
     */
    public function testIterator()
    {
        $iterator = new \IteratorIterator(new \ArrayIterator([1, 2, 3]));
        $result = Conversions::mixedToIterator($iterator);
        $this->assertEquals($iterator, $result);
    }

    /**
     * Unsupported type should result in an exception
     */
    public function testInvalidIterator()
    {
        $this->expectException(\Error::class);
        Conversions::mixedToIterator(false);
    }
}
