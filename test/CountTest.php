<?php

class CountTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodCount($start, $step, $expected)
    {
        $iterator = iter\count($start, $step);
        $this->assertInstanceOf('iter\CountIterator', $iterator);

        foreach ($expected as $key => $value) {
            $this->assertEquals($key, $iterator->key());
            $this->assertEquals($value, $iterator->current());
            $iterator->next();
        }
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($start, $step)
    {
        $iterator = iter\count($start, $step);
    }

    public function goodSequenceProvider()
    {
        return array(
            array(0, 0, array(0, 0, 0, 0)),
            array(0, 1, array(0, 1, 2, 3)),
            array(0, -1, array(0, -1, -2, -3)),
            array(0, 3, array(0, 3, 6, 9)),
            array(0, -3, array(0, -3, -6, -9)),
            array(2, 1, array(2, 3, 4, 5)),
            array(2, -1, array(2, 1, 0, -1)),

            array(0.0, 0.0, array(0.0, 0.0, 0.0, 0.0)),
            array(0.0, 0.1, array(0.0, 0.1, 0.2, 0.3)),
            array(0.0, -0.1, array(0.0, -0.1, -0.2, -0.3)),
            array(0.0, 3.5, array(0.0, 3.5, 7.0, 10.5)),
            array(0.0, -3.5, array(0.0, -3.5, -7.0, -10.5)),
            array(2.0, 0.1, array(2.0, 2.1, 2.2, 2.3)),
            array(2.0, -0.1, array(2.0, 1.9, 1.8, 1.7)),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array('0', 1),
            array(0, '1'),
            array(array(), 1),
            array(0, array()),
            array(null, 1),
            array(0, null),
        );
    }
}