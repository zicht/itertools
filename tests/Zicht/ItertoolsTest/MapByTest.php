<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Zicht\ItertoolsTest\Containers\SimpleObject;

/**
 * Class MapByTest
 *
 * @package Zicht\ItertoolsTest
 */
class MapByTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test mapBy
     *
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\mapBy', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapByIterator', $iterator);
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
     * Test deprecated keyCallback
     *
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testDeprecatedKeyCallback(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\keyCallback', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapByIterator', $iterator);
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
     * Provides tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        $addClosure = function ($a) {
            return $a + 10;
        };

        return array(
            // callback
            array(
                array($addClosure, array(1, 2, 3)),
                array(11, 12, 13),
                array(1, 2, 3),
            ),
            // duplicate keys
            array(
                array($addClosure, array(1, 2, 3, 3, 1, 2)),
                array(11, 12, 13, 13, 11, 12),
                array(1, 2, 3, 3, 1, 2),
            ),
            // use string to identify array key
            array(
                array('key', array(array('key' => 'k1'), array('key' => 'k2'), array('key' => 'k3'))),
                array('k1', 'k2', 'k3'),
                array(array('key' => 'k1'), array('key' => 'k2'), array('key' => 'k3')),
            ),
            array(
                array('key', array(array('key' => 1), array('key' => 2), array('key' => 3))),
                array(1, 2, 3),
                array(array('key' => 1), array('key' => 2), array('key' => 3)),
            ),
            // use string to identify object property
            array(
                array('prop', array(new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3'))),
                array('p1', 'p2', 'p3'),
                array(new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')),
            ),
            array(
                array('prop', array(new SimpleObject(1), new SimpleObject(2), new SimpleObject(3))),
                array(1, 2, 3),
                array(new SimpleObject(1), new SimpleObject(2), new SimpleObject(3)),
            ),
            // use string to identify object get method
            array(
                array('getProp', array(new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3'))),
                array('p1', 'p2', 'p3'),
                array(new SimpleObject('p1'), new SimpleObject('p2'), new SimpleObject('p3')),
            ),
            array(
                array('getProp', array(new SimpleObject(1), new SimpleObject(2), new SimpleObject(3))),
                array(1, 2, 3),
                array(new SimpleObject(1), new SimpleObject(2), new SimpleObject(3))
            ),
            // use null as value getter, this returns the value itself
            array(
                array(null, array('a' => 1, 'b' => 2, 'c' => 3)),
                array(1, 2, 3),
                array(1, 2, 3),
            ),
        );
    }

    /**
     * Test mapBy using invalid arguments
     *
     * @param array $arguments
     *
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\mapBy', $arguments);
    }

    /**
     * Provides invalid tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return array(
            array(array(123, array(1, 2, 3))),
            array(array(true, array(1, 2, 3))),
        );
    }
}
