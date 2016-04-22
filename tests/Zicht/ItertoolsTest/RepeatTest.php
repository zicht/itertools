<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class RepeatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodRepeat($object, $times)
    {
        $iterator = \Zicht\Itertools\repeat($object, $times);
        $this->assertInstanceOf('\Zicht\Itertools\lib\RepeatIterator', $iterator);

        $actialTestTimes = $times === null ? 2 : $times;
        for ($key=0; $key<$actialTestTimes; $key++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($object, $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        if (null !== $times) {
            $this->assertFalse($iterator->valid());
        }
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($object, $times)
    {
        $iterator = \Zicht\Itertools\repeat($object, $times);
    }

    public function goodSequenceProvider()
    {
        return array(
            array(0, 0),
            array(0, 1),
            array(0, 3),
            array(0, 42),
            array(0, null),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(0, '1'),
            array(0, 1.0),
            array(0, -1),
            array(0, array()),
        );
    }
}
