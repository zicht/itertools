<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class LastTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $value = call_user_func_array('\Zicht\Itertools\last', $arguments);
        $this->assertEquals($value, $expected);
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\last', $arguments);
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
            // test last
            array(
                array(array(0)),
                0,
            ),
            array(
                array(array(0, 1, 2, 3)),
                3,
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