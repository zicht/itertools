<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ChainTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\chain', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ChainIterator', $iterator);
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
    public function testBadArgument($iterables)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\chain', $iterables);
    }

    public function goodSequenceProvider()
    {
        return array(
            # data set #0
            array(
                array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)),
                array(0, 1, 2, 0, 1, 2, 0, 1, 2),
                array(1, 2, 3, 4, 5, 6, 7, 8, 9)),
            # data set #1
            array(
                array(array(1, 2, 3), array(), array(7, 8, 9)),
                array(0, 1, 2, 0, 1, 2),
                array(1, 2, 3, 7, 8, 9)),
            # data set #2
            array(
                array(array(1, 2, 3), array()),
                array(0, 1, 2),
                array(1, 2, 3)),
            # data set #3
            array(
                array(array(), array(4, 5, 6)),
                array(0, 1, 2),
                array(4, 5, 6)),
            # data set #4
            array(
                array(),
                array(),
                array()),
            # data set #5
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), array('d' => 4, 'e' => 5, 'f' => 6)),
                array('a', 'b', 'c', 'd', 'e', 'f'),
                array(1, 2, 3, 4, 5, 6))
            // todo: iterator
            // todo: strings
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(1)),
            array(array(1.0)),
            array(array(true)),
        );
    }
}
