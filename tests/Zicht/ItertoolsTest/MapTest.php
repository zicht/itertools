<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class MapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodMap(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\map', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapIterator', $iterator);

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->value()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($value, $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArguments(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\map', $arguments);
    }

    public function goodSequenceProvider()
    {
        $add10 = function ($a=0, $b=0, $c=0) { return 10 + $a + $b + $c; };

        return array(
            // single iterable
            array(
                array($add10, array(1, 2, 3)),
                array(11, 12, 13)),
            array(
                array($add10, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a' => 11, 'b' => 12, 'c' => 13)),
            array(
                array($add10, array(1 => 1, 2 => 2, 3 => 3)),
                array(1 => 11, 2 => 12, 3 => 13)),
            array(
                array($add10, array(1 => 1, 'b' => 2, 3 => 3)),
                array(1 => 11, 'b' => 12, 3 => 13)),
            // multiple iterables of equal length
            array(
                array($add10, array(1, 2, 3), array(4, 5, 6)),
                array(15, 17, 19)),
            array(
                array($add10, array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)),
                array(22, 25, 28)),
            // multiple iterables of unequal length
            array(
                array($add10, array(1, 2), array(4, 5, 6), array(7, 8, 9)),
                array(22, 25)),
            array(
                array($add10, array(1, 2, 3), array(4, 5), array(7, 8, 9)),
                array(22, 25)),
            array(
                array($add10, array(1, 2, 3), array(4, 5, 6), array(7, 8)),
                array(22, 25)),
            // multiple with different keys
            array(
                array($add10, array(1 => 1, 2 => 2, 3 => 3), array(4 => 4, 5 => 5, 6 => 6)),
                array('1:4' => 15, '2:5' => 17, '3:6' => 19)),
            array(
                array($add10, array('a' => 1, 'b' => 2, 'c' => 3), array(4 => 4, 5 => 5, 6 => 6)),
                array('a:4' => 15, 'b:5' => 17, 'c:6' => 19)),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(null, array(1, 2, 3))),
        );
    }
}
