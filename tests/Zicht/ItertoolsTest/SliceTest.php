<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class SliceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test using the infinite count iterable
     */
    public function testCombinedWithCountStartingAtZero()
    {
        // [0, 1, 2, 3, ...][0:3] -> [0, 1, 2]
        $iterator = \Zicht\Itertools\count(0)->slice(0, 3);
        $this->assertEquals(3, sizeof($iterator));

        $iterator->rewind();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(0, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(0, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(1, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(1, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(2, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(2, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertFalse($iterator->valid(), 'Failure in $iterator->valid()');
    }

    /**
     * Test using the infinite count iterable
     */
    public function testCombinedWithCountStartingAtNonZero()
    {
        // [0, 1, 2, 3, ...][2:5] -> [2, 3, 4]
        $iterator = \Zicht\Itertools\count(0)->slice(2, 5);
        $this->assertEquals(3, sizeof($iterator));

        $iterator->rewind();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(2, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(2, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(3, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(3, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(4, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(4, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertFalse($iterator->valid(), 'Failure in $iterator->valid()');
    }

    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\slice', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\SliceIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues), 'Failure in expected input length');
        $this->assertEquals(sizeof($expectedKeys), sizeof($iterator), 'Failure in input length (a)');
        $this->assertEquals(sizeof($expectedKeys), iterator_count($iterator), 'Failure in input length (b)');

        for ($rewindCounter=0; $rewindCounter<2; $rewindCounter++) {
            $iterator->rewind();

            for ($index=0; $index<sizeof($expectedKeys); $index++) {
                $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
                $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
                $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
                $iterator->next();
            }

            $this->assertFalse($iterator->valid(), 'Failure in $iterator->valid()');
        }
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\slice', $arguments);
    }

    public function goodSequenceProvider()
    {
        return array(
            // expect everything returned
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 3),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 99),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),

            // remove the first parts
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 1),
                array('b', 'c'),
                array(2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 2),
                array('c'),
                array(3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 3),
                array(),
                array(),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 4),
                array(),
                array(),
            ),

            // remove the first parts using a negative $begin
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), -1),
                array('c'),
                array(3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), -2),
                array('b', 'c'),
                array(2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), -3),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), -4),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),

            // remove the last parts
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 4),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 3),
                array('a', 'b', 'c'),
                array(1, 2, 3),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 2),
                array('a', 'b'),
                array(1, 2),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 1),
                array('a'),
                array(1),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, 0),
                array(),
                array(),
            ),

            // remove the last parts using a negative $end
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, -1),
                array('a', 'b'),
                array(1, 2),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, -2),
                array('a'),
                array(1),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, -3),
                array(),
                array(),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3), 0, -4),
                array(),
                array(),
            ),

            // remove the first and last parts
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5), 1, 4),
                array('b', 'c', 'd'),
                array(2, 3, 4),
            ),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5), -4, -1),
                array('b', 'c', 'd'),
                array(2, 3, 4),
            ),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(array(), 'must-be-integer')),
            array(array(array(), null)),
            array(array(array(), 1.0)),
            array(array(array(), 0, 'must-be-integer')),
            array(array(array(), 0, 1.0)),
        );
    }
}
