<?php

class MapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodMap(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('iter\map', $arguments);
        $this->assertInstanceOf('iter\MapIterator', $iterator);

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
        $iterator = call_user_func_array('iter\map', $arguments);
    }

    public function goodSequenceProvider()
    {
        $add10 = function ($a=0, $b=0, $c=0) { return 10 + $a + $b + $c; };
        
        return array(
            // single iterable
            array(
                array($add10, array(1, 2, 3)),
                array(11, 12, 13)),
            array(
                array($add10, array('a'=>1, 'b'=>2, 'c'=>3)),
                array(11, 12, 13)),
            // multiple iterables of equal length
            array(
                array($add10, array(1, 2, 3), array(4, 5, 6)),
                array(15, 17, 19)),
            array(
                array($add10, array(1, 2, 3), array(4, 5, 6), array(7, 8, 9)),
                array(22, 25, 28)),
            // multiple iterables of unequal length
            array(
                array($add10, array(1, 2), array(4, 5, 6), array(7, 8, 9)),
                array(22, 25)),
            array(
                array($add10, array(1, 2, 3), array(4, 5), array(7, 8, 9)),
                array(22, 25)),
            array(
                array($add10, array(1, 2, 3), array(4, 5, 6), array(7, 8)),
                array(22, 25)),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(null, array(1, 2, 3))),
        );
    }
}