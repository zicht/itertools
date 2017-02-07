<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

/**
 * Class AllTest
 *
 * @package Zicht\ItertoolsTest
 */
class AllTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, $expected)
    {
        $result = call_user_func_array('\Zicht\Itertools\all', $arguments);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
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
                true,
            ],
            [
                [[1]],
                true,
            ],
            [
                [[1, 1, 1]],
                true,
            ],
            [
                [[1, 0, 1]],
                false,
            ],
            [
                [[0, 1, 0]],
                false,
            ],
            [
                [[0, 1, 0]],
                false,
            ],

            // call WITH 'null' $keyStrategy
            [
                [null, []],
                true,
            ],
            [
                [null, [1]],
                true,
            ],
            [
                [null, [1, 1, 1]],
                true,
            ],
            [
                [null, [1, 0, 1]],
                false,
            ],
            [
                [null, [0, 1, 0]],
                false,
            ],
            [
                [null, [0, 1, 0]],
                false,
            ],

            // call WITH $keyStrategy
            [
                [$isEven, [1, 2, 3]],
                false,
            ],
            [
                [$isEven, [2, 4, 6]],
                true,
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\all', $arguments);
    }

    /**
     * Provides bad sequence tests
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
