<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class MapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodMap(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\map', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapIterator', $iterator);

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
                array(0, 1, 2),
                array(11, 12, 13),
            ),
            array(
                array($addSingle, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a', 'b', 'c'),
                array(11, 12, 13),
            ),
            array(
                array($addSingle, array(1 => 1, 2 => 2, 3 => 3)),
                array(1, 2, 3),
                array(11, 12, 13),
            ),
            array(
                array($addSingle, array(1 => 1, 'b' => 2, 3 => 3)),
                array(1, 'b', 3),
                array(11, 12, 13),
            ),

            // single iterable using both key and value
            array(
                array($swapSingle, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a', 'b', 'c'),
                array('a', 'b', 'c'),
            ),
            array(
                array($combineSingle, array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a', 'b', 'c'),
                array(array(1, 'a'), array(2, 'b'), array(3, 'c')),
            ),

            // multiple iterables of equal length
            array(
                array($addDouble, array(1, 2, 3), array(4, 5, 6)),
                array(0, 1, 2),
                array(15, 17, 19),
            ),
            array(
                array($addTriple, array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)),
                array(0, 1, 2),
                array(22, 25, 28),
            ),

            // multiple iterables using both keys and values
            array(
                array($swapDouble, array('a' => 1, 'b' => 2, 'c' => 3), array('d' => 4, 'e' => 5, 'f' => 6)),
                array('a:d', 'b:e', 'c:f'),
                array(array('a', 'd'), array('b', 'e'), array('c', 'f')),
            ),
            array(
                array($combineDouble, array('a' => 1, 'b' => 2, 'c' => 3), array('d' => 4, 'e' => 5, 'f' => 6)),
                array('a:d', 'b:e', 'c:f'),
                array(array(1, 4, 'a', 'd'), array(2, 5, 'b', 'e'), array(3, 6, 'c', 'f')),
            ),

            // multiple iterables of unequal length
            array(
                array($addTriple, array(1, 2), array(4, 5, 6), array(7, 8, 9)),
                array(0, 1),
                array(22, 25),
            ),
            array(
                array($addTriple, array(1, 2, 3), array(4, 5), array(7, 8, 9)),
                array(0, 1),
                array(22, 25),
            ),
            array(
                array($addTriple, array(1, 2, 3), array(4, 5, 6), array(7, 8)),
                array(0, 1),
                array(22, 25),
            ),

            // multiple with different keys
            array(
                array($addDouble, array(1 => 1, 2 => 2, 3 => 3), array(4 => 4, 5 => 5, 6 => 6)),
                array('1:4', '2:5', '3:6'),
                array(15, 17, 19),
            ),
            array(
                array($addDouble, array('a' => 1, 'b' => 2, 'c' => 3), array(4 => 4, 5 => 5, 6 => 6)),
                array('a:4', 'b:5', 'c:6'),
                array(15, 17, 19),
            ),

            // test several ways that php handles array keys *shudder*:
            // - '0' becomes 0
            // - '7 ' stays '7 '
            // - '1.0' stays '1.0'
            // - 3.0 becomes 3
            // - 4.1 becomes 4
            // - 5.5 becomes 5
            // - 6.9 becomes 6
            array(
                array(
                    $addDouble,
                    array('0' => 1, 'b' => 2, 3.0 => 3, 'D' => 4, '1.0' => 5, 4.1 => 6,  5.5 => 7, 6.9 => 8, '7 ' => 9),
                    array(0 => 1,   'b' => 2, '3' => 3, 'd' => 4,  1 => 5,   '4.1' => 6, 5 => 7,   6 => 8,   7 => 9)
                ),
                array(0, 'b', 3, 'D:d', '1.0:1', '4:4.1', 5, 6, '7 :7'),
                array(12, 14, 16, 18, 20, 22, 24, 26, 28),
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
