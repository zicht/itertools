<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class FirstTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $value = call_user_func_array('\Zicht\Itertools\first', $arguments);
        $this->assertEquals($value, $expected);
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\first', $arguments);
    }

    public function goodSequenceProvider()
    {
        return array(
            // test default values
            array(
                array(array()),
                null,
            ),
            array(
                array(array(), 'default'),
                'default',
            ),
            array(
                array('', 'default'),
                'default',
            ),
            // test first
            array(
                array(array(0)),
                0,
            ),
            array(
                array(array(0, 1, 2, 3)),
                0,
            ),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(0)),
            array(array(1.0)),
            array(array(true)),
            array(array(function () { return []; })),
        );
    }}