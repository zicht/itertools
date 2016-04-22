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
        $addSingle = function ($a=0) { return 10 + $a; };
        $addDouble = function ($a=0, $b=0) { return 10 + $a + $b; };
        $addTriple = function ($a=0, $b=0, $c=0) { return 10 + $a + $b + $c; };

        $swapSingle = function ($first, $second) { return $second; };
        $swapDouble = function ($first, $second, $third, $fourth) { return array($third, $fourth); };

        $combineSingle = function ($first, $second) { return array($first, $second); };
        $combineDouble = function ($first, $second, $third, $fourth) { return array($first, $second, $third, $fourth); };

        return array(
            // single iterable
            array(
                array($addSingle, array(1, 2, 3)),
                array(11, 12, 13)),
            array(
                array($addSingle, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a' => 11, 'b' => 12, 'c' => 13)),
            array(
                array($addSingle, array(1 => 1, 2 => 2, 3 => 3)),
                array(1 => 11, 2 => 12, 3 => 13)),
            array(
                array($addSingle, array(1 => 1, 'b' => 2, 3 => 3)),
                array(1 => 11, 'b' => 12, 3 => 13)),

            // single iterable using both key and value
            array(
                array($swapSingle, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a' => 'a', 'b' => 'b', 'c' => 'c'),
            ),
            array(
                array($combineSingle, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a' => array(1, 'a'), 'b' => array(2, 'b'), 'c' => array(3, 'c')),
            ),

            // multiple iterables of equal length
            array(
                array($addDouble, array(1, 2, 3), array(4, 5, 6)),
                array(15, 17, 19)),
            array(
                array($addTriple, array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)),
                array(22, 25, 28)),

            // multiple iterables using both keys and values
            array(
                array($swapDouble, array('a' => 1, 'b' => 2, 'c' => 3), array('d' => 4, 'e' => 5, 'f' => 6)),
                array('a:d' => array('a', 'd'), 'b:e' => array('b', 'e'), 'c:f' => array('c', 'f')),
            ),
            array(
                array($combineDouble, array('a' => 1, 'b' => 2, 'c' => 3), array('d' => 4, 'e' => 5, 'f' => 6)),
                array('a:d' => array(1, 4, 'a', 'd'), 'b:e' => array(2, 5, 'b', 'e'), 'c:f' => array(3, 6, 'c', 'f')),
            ),

            // multiple iterables of unequal length
            array(
                array($addTriple, array(1, 2), array(4, 5, 6), array(7, 8, 9)),
                array(22, 25)),
            array(
                array($addTriple, array(1, 2, 3), array(4, 5), array(7, 8, 9)),
                array(22, 25)),
            array(
                array($addTriple, array(1, 2, 3), array(4, 5, 6), array(7, 8)),
                array(22, 25)),

            // multiple with different keys
            array(
                array($addDouble, array(1 => 1, 2 => 2, 3 => 3), array(4 => 4, 5 => 5, 6 => 6)),
                array('1:4' => 15, '2:5' => 17, '3:6' => 19)),
            array(
                array($addDouble, array('a' => 1, 'b' => 2, 'c' => 3), array(4 => 4, 5 => 5, 6 => 6)),
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
