<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

class LastTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $arguments
     * @param mixed $expected
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $value = call_user_func_array('\Zicht\Itertools\last', $arguments);
        $this->assertEquals($value, $expected);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
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
            // test last
            [
                [[0]],
                0,
            ],
            [
                [[0, 1, 2, 3]],
                3,
            ],
        ];
    }

    /**
     * @param array $arguments
     * @param mixed $expected
     * @dataProvider goodKeySequenceProvider
     */
    public function testKeyGoodSequence(array $arguments, $expected)
    {
        $value = call_user_func_array('\Zicht\Itertools\last_key', $arguments);
        $this->assertEquals($value, $expected);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
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
            // test last
            [
                [['a' => 0]],
                'a',
            ],
            [
                [['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3]],
                'd',
            ],
        ];
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
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[0]],
            [[1.0]],
            [[true]],
            [[function () {
                return [];
            },
            ],
            ],
        ];
    }
}
