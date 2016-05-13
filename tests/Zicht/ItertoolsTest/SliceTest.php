<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class SliceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodKeyCallback(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\slice', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\SliceIterator', $iterator);
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
