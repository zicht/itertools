<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class AllTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     * @param mixed $expected
     * @dataProvider goodSequenceWithoutStrategyProvider
     */
    public function testGoodSequenceWithoutStrategy(array $data, $expected)
    {
        $result = iterable($data)->all();
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceWithoutStrategyProvider()
    {
        return [
            [
                [],
                true,
            ],
            [
                [1],
                true,
            ],
            [
                [1, 1, 1],
                true,
            ],
            [
                [1, 0, 1],
                false,
            ],
            [
                [0, 1, 0],
                false,
            ],
            [
                [0, 0, 1],
                false,
            ],
        ];
    }

    /**
     * @param array $data
     * @param mixed $strategy
     * @param mixed $expected
     * @dataProvider goodSequenceWithStrategyProvider
     */
    public function testGoodSequenceWithStrategy(array $data, $strategy, $expected)
    {
        $result = iterable($data)->all($strategy);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceWithStrategyProvider()
    {
        $isEven = fn($value) => $value % 2 == 0;

        return [
            // call WITH 'null' $keyStrategy
            [
                [],
                null,
                true,
            ],
            [
                [1],
                null,
                true,
            ],
            [
                [1, 1, 1],
                null,
                true,
            ],
            [
                [1, 0, 1],
                null,
                false,
            ],
            [
                [0, 1, 0],
                null,
                false,
            ],
            [
                [0, 1, 0],
                null,
                false,
            ],

            // call WITH $keyStrategy
            [
                [1, 2, 3],
                $isEven,
                false,
            ],
            [
                [2, 4, 6],
                $isEven,
                true,
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $data)
    {
        iterable($data)->all();
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
// todo: fixure out the new equivalent arguments
//            // wrong types
//            [[0]],
//            [[1.0]],
//            [[true]],
//
//            // wrong argument count
//            [[]],
//            [[
//                function ($value) {
//                    return $value;
//                }, [1, 2, 3], 'one argument to many',
//            ],
//            ],
        ];
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->all());
    }
}
