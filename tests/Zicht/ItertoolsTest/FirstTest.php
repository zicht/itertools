<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

/**
 * Class FirstTest
 *
 * @package Zicht\ItertoolsTest
 */
class FirstTest extends \PHPUnit_Framework_TestCase
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
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            // test default values
            [
                [[]],
                null,
            ],
            [
                [[], 'default'],
                'default',
            ],
            [
                ['', 'default'],
                'default',
            ],
            // test first
            [
                [[0]],
                0,
            ],
            [
                [[0, 1, 2, 3]],
                0,
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\first', $arguments);
    }

    /**
     * Provides bad sequence tests
     */
    public function badArgumentProvider()
    {
        return [
            [[0]],
            [[1.0]],
            [[true]],
            [[function () {
                return [];
            }]],
        ];
    }
}