<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ReduceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodReduce($iterable, $closure, $default, $expected)
    {
        $result = \Zicht\Itertools\reduce($iterable, $closure, $default);
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($iterable, $closure, $default)
    {
        $result = \Zicht\Itertools\reduce($iterable, $closure, $default);
    }

    public function goodSequenceProvider()
    {
        return array(
            array(array(1, 2, 3), 'add', null, 6),
            array(array(1, 2, 3), 'sub', null, -4),
            array(array(1, 2, 3), 'mul', null, 6),
            array(array(1, 2, 3), 'min', null, 1),
            array(array(1, 2, 3), 'max', null, 3),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(0, 'add', null),
            array(null, 'add', null),
            array(array(), 0, null),
            array(array(), null, null),
            array(array(), 'unknown', null),
        );
    }
}
