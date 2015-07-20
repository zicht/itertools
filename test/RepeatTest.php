<?php

class RepeatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodRepeat($object, $times)
    {
        $iterator = iter\repeat($object, $times);
        $this->assertInstanceOf('iter\RepeatIterator', $iterator);

        for ($key=0; $key<$times; $key++) {
            $this->assertTrue($iterator->valid());
            $this->assertEquals($key, $iterator->key());
            $this->assertEquals($object, $iterator->current());
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
        $iterator = iter\repeat($object, $times);
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