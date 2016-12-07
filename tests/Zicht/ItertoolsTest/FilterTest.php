<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools as iter;

/**
 * Class FilterTest
 *
 * @package Zicht\ItertoolsTest
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test good sequences
     *
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     * @dataProvider goodBackwardsCompatibleSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\filter', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($iterator), sizeof($expectedKeys));
        $this->assertEquals(iterator_count($iterator), sizeof($expectedKeys));
        $iterator->rewind();

        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        for ($index=0; $index<sizeof($expectedKeys); $index++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * Test good sequences on deprecated filterBy
     *
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodBackwardsCompatibleSequenceProvider
     */
    public function testDeprecatedFilterBy(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\filterBy', array_merge([null], $arguments));
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($iterator), sizeof($expectedKeys));
        $this->assertEquals(iterator_count($iterator), sizeof($expectedKeys));
        $iterator->rewind();

        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        for ($index=0; $index<sizeof($expectedKeys); $index++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * Provides good sequence tests
     */
    public function goodBackwardsCompatibleSequenceProvider()
    {
        $trueClosure = function () {
            return true;
        };

        $falseClosure = function () {
            return false;
        };

        $isPositiveClosure = function ($value) {
            return 0 < $value;
        };

        $isNegativeClosure = function ($value) {
            return $value < 0;
        };

        return array(
            // with closure
            array(
                array($trueClosure, array(0, -1, 2, -3)),
                array(0, 1, 2, 3),
                array(0, -1, 2, -3)),
            array(
                array($falseClosure, array(0, -1, 2, -3)),
                array(),
                array()),
            array(
                array($isPositiveClosure, array(0, -1, 2, -3)),
                array(2),
                array(2)),
            array(
                array($isNegativeClosure, array(0, -1, 2, -3)),
                array(1, 3),
                array(-1, -3)),

            // without closure (this uses !empty as a closure)
            array(
                array(array(1, 2, 3)),
                array(0, 1, 2),
                array(1, 2, 3)),
            array(
                array(array(null, '', 0, '0')),
                array(),
                array()),
        );
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        $hasSmallIndex = function ($value, $key) {
            return $key < 3;
        };

        $hasLargeIndex = function ($value, $key) {
            return 3 <= $key;
        };

        return array(
            // single iterable using both key and value
            array(
                array($hasSmallIndex, array('a', 'b', 'c', 'd', 'e')),
                array(0, 1, 2),
                array('a', 'b', 'c'),
            ),
            array(
                array($hasLargeIndex, array('a', 'b', 'c', 'd', 'e')),
                array(3, 4),
                array('d', 'e'),
            ),
        );
    }

    /**
     * Test filter using invalid arguments
     *
     * @param array $arguments
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\filter', $arguments);
    }

    /**
     * Test filter using invalid arguments
     *
     * @expectedException \InvalidArgumentException
     */
    public function testDeprecatedFilterByBadArgument()
    {
        iter\filterBy(1, 2, 3, 4);
    }

    /**
     * Provides invalid tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return array(
            array(array()),
            array(array(0)),
            array(array(1.0)),
            array(array(true)),
            array(array(0, array())),
        );
    }
}
