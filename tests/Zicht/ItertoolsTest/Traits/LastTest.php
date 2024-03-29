<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class LastTest extends TestCase
{
    /**
     * @param array $data
     * @param array $arguments
     * @param mixed $expected
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $data, array $arguments, $expected)
    {
        $value = iterable($data)->last(...$arguments);
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
                [],
                [],
                null,
            ],
            [
                [],
                ['default'],
                'default',
            ],
            // test last
            [
                [0],
                [],
                0,
            ],
            [
                [0, 1, 2, 3],
                [],
                3,
            ],
        ];
    }

    /**
     * @param array $data
     * @param array $arguments
     * @param mixed $expected
     * @dataProvider goodKeySequenceProvider
     */
    public function testKeyGoodSequence(array $data, array $arguments, $expected)
    {
        $value = iterable($data)->lastKey(...$arguments);
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
                [],
                [],
                null,
            ],
            [
                [],
                ['default'],
                'default',
            ],
            // test last
            [
                ['a' => 0],
                [],
                'a',
            ],
            [
                ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3],
                [],
                'd',
            ],
        ];
    }

//    /**
//     * @dataProvider badArgumentProvider
//     */
//    public function testBadArgument(array $arguments)
//    {
//        $this->expectException(\Error::class);
//        call_user_func_array('\Zicht\Itertools\last', $arguments);
//    }
//
//    /**
//     * Provides bad sequence tests
//     *
//     * @return array
//     */
//    public function badArgumentProvider()
//    {
//        return [
//            [[0]],
//            [[1.0]],
//            [[true]],
//            [[function () {
//                return [];
//            },
//            ],
//            ],
//        ];
//    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertEquals(3, $iterable->last());
        $this->assertEquals(2, $iterable->lastKey());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->last());
        $this->assertNull($nonIterator->lastKey());
    }
}
