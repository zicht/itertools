<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ReduceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, $closure, $default, $expected)
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

            // test behavior of default value
            array(array(), 'add', null, null),
            array(array(), 'add', 2, 2),
            array(array(1), 'add', 2, 3),
            array(array(), 'sub', 2, 2),
            array(array(1), 'sub', 2, 1),

        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(0, 'add', null),
            array(1.0, 'add', null),
            array(true, 'add', null),
            array(array(), 0, null),
            array(array(), null, null),
            array(array(), 'unknown', null),
        );
    }
}
