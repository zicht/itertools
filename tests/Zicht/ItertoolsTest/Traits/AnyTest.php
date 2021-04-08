<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class AnyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     * @param array $arguments
     * @param mixed $expected
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $data, array $arguments, $expected)
    {
        $result = iterable($data)->any(...$arguments);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        $isEven = fn($value) => $value % 2 == 0;

        return [
            // call WITHOUT $keyStrategy
            [
                [],
                [],
                false,
            ],
            [
                [0],
                [],
                false,
            ],
            [
                [0, 0, 0],
                [],
                false,
            ],
            [
                [1, 0, 1],
                [],
                true,
            ],
            [
                [0, 1, 0],
                [],
                true,
            ],
            [
                [0, 0, 1],
                [],
                true,
            ],

            // call WITH 'null' $keyStrategy
            [
                [],
                [null],
                false,
            ],
            [
                [0],
                [null],
                false,
            ],
            [
                [0, 0, 0],
                [null],
                false,
            ],
            [
                [1, 0, 1],
                [null],
                true,
            ],
            [
                [0, 1, 0],
                [null],
                true,
            ],
            [
                [0, 0, 1],
                [null],
                true,
            ],

            // call WITH $keyStrategy
            [
                [1, 2, 3],
                [$isEven],
                true,
            ],
            [
                [1, 3, 5],
                [$isEven],
                false,
            ],
        ];
    }

    /**
     * @expectedException \TypeError
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        iterable([1, 2, 3])->any(...$arguments);
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
//            [[]],
//            [
//                [
//                    function ($value) {
//                        return $value;
//                    },
//                    [1, 2, 3],
//                    'one argument to many',
//                ],
//            ],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertEquals(true, $iterable->any());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->any());
    }
}
