<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class FilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodKeyCallback(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\filter', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
        $iterator->rewind();

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
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\filter', $arguments);
    }

    public function goodSequenceProvider()
    {
        return array(
            // with closure
            array(
                array(function ($a) { return true; }, array(0, -1, 2, -3)),
                array(0, -1, 2, -3),
            ),
            array(
                array(function ($a) { return false; }, array(0, -1, 2, -3)),
                array(),
            ),
            array(
                array(function ($a) { return 0 < $a; }, array(0, -1, 2, -3)),
                array(2 => 2),
            ),
            array(
                array(function ($a) { return $a < 0; }, array(0, -1, 2, -3)),
                array(1 => -1, 3 => -3),
            ),

            // without closure (this uses !empty as a closure)
            array(
                array(array(1, 2, 3)),
                array(1, 2, 3),
            ),
            array(
                array(array(null, '', 0, '0')),
                array(),
            ),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array()),
            array(array(null)),
            array(array(null, null)),
            array(array(null, null, null)),
        );
    }
}
