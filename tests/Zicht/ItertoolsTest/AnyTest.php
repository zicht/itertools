<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class AnyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $result = call_user_func_array('\Zicht\Itertools\any', $arguments);
        $this->assertEquals($expected, $result);
    }

    public function goodSequenceProvider()
    {
        $isEven = function ($value) { return $value % 2 == 0; };

        return array(
            // call WITHOUT $keyStrategy
            array(
                array(array()),
                false,
            ),
            array(
                array(array(0)),
                false,
            ),
            array(
                array(array(0, 0 ,0)),
                false,
            ),
            array(
                array(array(1, 0, 1)),
                true,
            ),
            array(
                array(array(0, 1, 0)),
                true,
            ),
            array(
                array(array(0, 1, 0)),
                true,
            ),

            // call WITH 'null' $keyStrategy
            array(
                array(null, array()),
                false,
            ),
            array(
                array(null, array(0)),
                false,
            ),
            array(
                array(null, array(0, 0 ,0)),
                false,
            ),
            array(
                array(null, array(1, 0, 1)),
                true,
            ),
            array(
                array(null, array(0, 1, 0)),
                true,
            ),
            array(
                array(null, array(0, 1, 0)),
                true,
            ),

            // call WITH $keyStrategy
            array(
                array($isEven, array(1, 2, 3)),
                true,
            ),
            array(
                array($isEven, array(1, 3, 5)),
                false,
            ),
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\unique', $arguments);
    }

    public function badArgumentProvider()
    {
        return array(
            // wrong types
            array(array(0)),
            array(array(1.0)),
            array(array(true)),

            // wrong argument count
            array(array()),
            array(array(function ($value) { return $value; }, array(1, 2, 3), 'one argument to many')),
        );
    }
}
