<?php

namespace Zicht\ItertoolsTest;

use ArrayIterator;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ReversedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expectedKeys, array $expectedValues)
    {
        $iterator = \Zicht\Itertools\reversed($iterable);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ReversedIterator', $iterator);
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
    public function testBadArgument($iterable)
    {
        $iterator = \Zicht\Itertools\reversed($iterable);
    }

    public function goodSequenceProvider()
    {
        return array(
            // empty input
            array(
                array(),
                array(),
                array(),
            ),

            // test simple reversal
            array(
                array(1, 2, 3),
                array(2, 1, 0),
                array(3, 2, 1)),

            // test duplicate keys reversal
            array(
                \Zicht\Itertools\chain(array(1, 2, 3), array(4, 5, 6)),
                array(2, 1, 0, 2, 1, 0),
                array(6, 5, 4, 3, 2, 1)),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(0),
            array(1.0),
            array(function () { return ''; }),
        );
    }
}
