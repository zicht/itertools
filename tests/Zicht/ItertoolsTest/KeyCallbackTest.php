<?php

namespace ItertoolsTest;

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

class KeyCallbackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodKeyCallback(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Itertools\keyCallback', $arguments);
        $this->assertInstanceOf('\Itertools\lib\KeyCallbackIterator', $iterator);
        $iterator->rewind();

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid());
            $this->assertEquals($key, $iterator->key());
            $this->assertEquals($value, $iterator->current());
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
        $iterator = call_user_func_array('\Itertools\keyCallback', $arguments);
    }

    public function goodSequenceProvider()
    {
        return array(
            // callback
            array(
                array(function ($a) { return $a + 10; }, array(1, 2, 3)),
                array(11 => 1, 12 => 2, 13 => 3)),
            // use string to identify array key
            array(
                array('key', array(array('key' => 'k1'), array('key' => 'k2'), array('key' => 'k3'))),
                array('k1' => array('key' => 'k1'), 'k2' => array('key' => 'k2'), 'k3' => array('key' => 'k3'))),
            array(
                array('key', array(array('key' => 1), array('key' => 2), array('key' => 3))),
                array(1 => array('key' => 1), 2 => array('key' => 2), 3 => array('key' => 3))),
            // use string to identify object property
            array(
                array('prop', array(new simpleObject('p1'), new simpleObject('p2'), new simpleObject('p3'))),
                array('p1' => new simpleObject('p1'), 'p2' => new simpleObject('p2'), 'p3' => new simpleObject('p3'))),
            array(
                array('prop', array(new simpleObject(1), new simpleObject(2), new simpleObject(3))),
                array(1 => new simpleObject(1), 2 => new simpleObject(2), 3 => new simpleObject(3))),
            // use string to identify object get method
            array(
                array('getProp', array(new simpleObject('p1'), new simpleObject('p2'), new simpleObject('p3'))),
                array('p1' => new simpleObject('p1'), 'p2' => new simpleObject('p2'), 'p3' => new simpleObject('p3'))),
            array(
                array('getProp', array(new simpleObject(1), new simpleObject(2), new simpleObject(3))),
                array(1 => new simpleObject(1), 2 => new simpleObject(2), 3 => new simpleObject(3))),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(null, array(1, 2, 3))),
        );
    }
}
