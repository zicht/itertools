<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class simpleObject
{
    public function __construct($value)
    {
        $this->prop = $value;
    }

    public function getProp()
    {
        return $this->prop;
    }
}

# todo: rename to MapByTest
class KeyCallbackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodKeyCallback(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\keyCallback', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\KeyCallbackIterator', $iterator);
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
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\keyCallback', $arguments);
    }

    public function goodSequenceProvider()
    {
        return array(
            // callback
            array(
                array(function ($a) { return $a + 10; }, array(1, 2, 3)),
                array(11, 12, 13),
                array(1, 2, 3),
            ),
            // duplicate keys
            array(
                array(function ($a) { return $a + 10; }, array(1, 2, 3, 3, 1, 2)),
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
                array('prop', array(new simpleObject('p1'), new simpleObject('p2'), new simpleObject('p3'))),
                array('p1', 'p2', 'p3'),
                array(new simpleObject('p1'), new simpleObject('p2'), new simpleObject('p3')),
            ),
            array(
                array('prop', array(new simpleObject(1), new simpleObject(2), new simpleObject(3))),
                array(1, 2, 3),
                array(new simpleObject(1), new simpleObject(2), new simpleObject(3)),
            ),
            // use string to identify object get method
            array(
                array('getProp', array(new simpleObject('p1'), new simpleObject('p2'), new simpleObject('p3'))),
                array('p1', 'p2', 'p3'),
                array(new simpleObject('p1'), new simpleObject('p2'), new simpleObject('p3')),
            ),
            array(
                array('getProp', array(new simpleObject(1), new simpleObject(2), new simpleObject(3))),
                array(1, 2, 3),
                array(new simpleObject(1), new simpleObject(2), new simpleObject(3))
            ),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(null, array(1, 2, 3))),
        );
    }
}
