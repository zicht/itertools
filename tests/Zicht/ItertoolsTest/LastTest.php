<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

/**
 * Class LastTest
 *
 * @package Zicht\ItertoolsTest
 */
class LastTest extends \PHPUnit_Framework_TestCase
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
     * Provides good sequence tests
     */
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

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\last', $arguments);
    }

    /**
     * Provides bad sequence tests
     */
    public function badArgumentProvider()
    {
        return array(
            array(array(0)),
            array(array(1.0)),
            array(array(true)),
            array(array(function () { return []; })),
        );
    }}