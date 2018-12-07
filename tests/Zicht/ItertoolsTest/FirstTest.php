<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

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
     * @dataProvider goodKeySequenceProvider
     */
    public function testKeyGoodSequence(array $arguments, $expected)
    {
        $value = call_user_func_array('\Zicht\Itertools\first_key', $arguments);
        $this->assertEquals($value, $expected);
    }

    /**
     * Provides good sequence tests
     */
    public function goodKeySequenceProvider()
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
                [['a' => 0]],
                'a',
            ],
            [
                [['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3]],
                'a',
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
