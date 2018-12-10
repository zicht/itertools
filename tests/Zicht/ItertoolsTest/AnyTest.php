<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

class AnyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $arguments
     * @param mixed $expected
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $result = call_user_func_array('\Zicht\Itertools\any', $arguments);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        $isEven = function ($value) {
            return $value % 2 == 0;
        };

        return [
            // call WITHOUT $keyStrategy
            [
                [[]],
                false,
            ],
            [
                [[0]],
                false,
            ],
            [
                [[0, 0, 0]],
                false,
            ],
            [
                [[1, 0, 1]],
                true,
            ],
            [
                [[0, 1, 0]],
                true,
            ],
            [
                [[0, 1, 0]],
                true,
            ],

            // call WITH 'null' $keyStrategy
            [
                [null, []],
                false,
            ],
            [
                [null, [0]],
                false,
            ],
            [
                [null, [0, 0, 0]],
                false,
            ],
            [
                [null, [1, 0, 1]],
                true,
            ],
            [
                [null, [0, 1, 0]],
                true,
            ],
            [
                [null, [0, 1, 0]],
                true,
            ],

            // call WITH $keyStrategy
            [
                [$isEven, [1, 2, 3]],
                true,
            ],
            [
                [$isEven, [1, 3, 5]],
                false,
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\any', $arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            // wrong types
            [[0]],
            [[1.0]],
            [[true]],

            // wrong argument count
            [[]],
            [[function ($value) {
                return $value;
            }, [1, 2, 3], 'one argument to many']],
        ];
    }
}
