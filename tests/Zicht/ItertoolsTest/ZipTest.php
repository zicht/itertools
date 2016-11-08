<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ZipTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\zip', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ZipIterator', $iterator);
        $this->assertEquals(sizeof($iterator), sizeof($expected));
        $this->assertEquals(iterator_count($iterator), sizeof($expected));
        $iterator->rewind();

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
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
        $iterator = call_user_func_array('\Zicht\Itertools\zip', $arguments);
    }

    public function goodSequenceProvider()
    {
        return array(
            // single iterable
            array(
                array(array()),
                array(),
            ),
            array(
                array(array(1, 2, 3)),
                array(array(1), array(2), array(3))),
            // double iterable
            array(
                array(array(), array()),
                array(),
            ),
            array(
                array(array(1, 2, 3), array(4, 5, 6)),
                array(array(1, 4), array(2, 5), array(3, 6))),
            // unequal input length
            array(
                array(array(), array(4, 5, 6)),
                array()
            ),
            array(
                array(array(1, 2, 3), array()),
                array()
            ),
            array(
                array(array(1), array(4, 5, 6)),
                array(array(1, 4))
            ),
            array(
                array(array(1, 2, 3), array(4)),
                array(array(1, 4))
            ),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(0)),
            array(array(1.0)),
            array(array(true)),
        );
    }
}
