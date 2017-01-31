<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Doctrine\Common\Collections\ArrayCollection;
use Zicht\Itertools\conversions;
use Zicht\ItertoolsTest\Dummies\DummyTraversable;

/**
 * Class MixedToIteratorTest
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class MixedToIteratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test NULL input
     */
    public function testNull()
    {
        $result = conversions\mixed_to_iterator(null);
        $this->assertEquals([], iterator_to_array($result));
    }

    /**
     * Test array input
     */
    public function testArray()
    {
        $result = conversions\mixed_to_iterator([1, 2, 3]);
        $this->assertEquals([1, 2, 3], iterator_to_array($result));
    }

    /**
     * Test string input
     */
    public function testString()
    {
        $result = conversions\mixed_to_iterator('Foo');
        $this->assertEquals(['F', 'o', 'o'], iterator_to_array($result));
    }

    /**
     * Test doctrine Collection input
     */
    public function testCollection()
    {
        $result = conversions\mixed_to_iterator(new ArrayCollection([1, 2, 3]));
        $this->assertEquals([1, 2, 3], iterator_to_array($result));
    }

    /**
     * Test Traversable input
     */
    public function testTraversable()
    {
        $result = conversions\mixed_to_iterator(new DummyTraversable([1, 2, 3]));
        $this->assertEquals([1, 2, 3], iterator_to_array($result));
    }

    /**
     * Test Iterator input
     */
    public function testIterator()
    {
        $iterator = new \IteratorIterator(new \ArrayIterator([1, 2, 3]));
        $result = conversions\mixed_to_iterator($iterator);
        $this->assertEquals($iterator, $result);
    }

    /**
     * Unsupported type should result in an exception
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIterator()
    {
        conversions\mixed_to_iterator(false);
    }
}
