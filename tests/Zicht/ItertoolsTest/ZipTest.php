<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ZipTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodMap(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\zip', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ZipIterator', $iterator);

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid());
            $this->assertEquals($key, $iterator->key());
            $this->assertEquals($value, $iterator->current());
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
                array(array(1, 2, 3)),
                array(array(1), array(2), array(3))),
            // double iterable
            array(
                array(array(1, 2, 3), array(4, 5, 6)),
                array(array(1, 4), array(2, 5), array(3, 6))),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(null)),
        );
    }
}
