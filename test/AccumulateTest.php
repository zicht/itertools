<?php

class AccumulateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodAccmulate($iterable, $func, $expected)
    {
        $iterator = iter\accumulate($iterable, $func);
        $this->assertInstanceOf('iter\AccumulateIterator', $iterator);
        $iterator->rewind();

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
    public function testBadArgument($iterable, $func)
    {
        $iterator = iter\accumulate($iterable, $func);
    }

    public function goodSequenceProvider()
    {
        return array(
            array(new ArrayIterator(array(1, 2, 3)), 'add', array(1, 3, 6)),
            array(array(1, 2, 3), 'add', array(1, 3, 6)),
            array(array(1, 2, 3), 'sub', array(1, -1, -4)),
            array(array(1, 2, 3), 'mul', array(1, 2, 6)),
            array(array(1, 2, 3), 'min', array(1, 1, 1)),
            array(array(1, 2, 3), 'max', array(1, 2, 3)),
            array(array(1, 2, 3), function ($a, $b) { return $a + $b; }, array(1, 3, 6)),
            array('Foo', function ($a, $b) { return $a . $b; }, array('F', 'Fo', 'Foo')),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(0, 'add'),
            array(null, 'add'),
            array(array(), 0),
            array(array(), null),
            array(array(), 'unknown'),
        );
    }
}