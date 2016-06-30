<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class AllTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $result = call_user_func_array('\Zicht\Itertools\all', $arguments);
        $this->assertEquals($expected, $result);
    }

    public function goodSequenceProvider()
    {
        $isEven = function ($value) { return $value % 2 == 0; };

        return array(
            // call WITHOUT $keyStrategy
            array(
                array(array()),
                true,
            ),
            array(
                array(array(1)),
                true,
            ),
            array(
                array(array(1, 1, 1)),
                true,
            ),
            array(
                array(array(1, 0, 1)),
                false,
            ),
            array(
                array(array(0, 1, 0)),
                false,
            ),
            array(
                array(array(0, 1, 0)),
                false,
            ),

            // call WITH 'null' $keyStrategy
            array(
                array(null, array()),
                true,
            ),
            array(
                array(null, array(1)),
                true,
            ),
            array(
                array(null, array(1, 1, 1)),
                true,
            ),
            array(
                array(null, array(1, 0, 1)),
                false,
            ),
            array(
                array(null, array(0, 1, 0)),
                false,
            ),
            array(
                array(null, array(0, 1, 0)),
                false,
            ),

            // call WITH $keyStrategy
            array(
                array($isEven, array(1, 2, 3)),
                false,
            ),
            array(
                array($isEven, array(2, 4, 6)),
                true,
            ),
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\all', $arguments);
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
