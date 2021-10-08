<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

class IntersectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = Itertools\iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\IntersectionIterator', $iterable->intersection([3, 4, 5]));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->intersection([]));
    }

    /**
     * @param mixed $baseIterable
     * @param mixed $compareIterable
     * @param mixed $strategy
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($baseIterable, $compareIterable, $strategy, array $expectedKeys, array $expectedValues)
    {
        $intersection = Itertools\iterable($baseIterable)->intersection($compareIterable, $strategy);
        $this->assertEquals($expectedKeys, $intersection->keys());
        $this->assertEquals($expectedValues, $intersection->values());
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [
                [],
                [],
                null,
                [],
                [],
            ],
            [
                [1, 2, 3],
                [],
                null,
                [],
                [],
            ],
            [
                [],
                [1, 2, 3],
                null,
                [],
                [],
            ],
            [
                [1, 2, 3],
                [2, 1, 5],
                null,
                [0, 1],
                [1, 2],
            ],
            [
                [1, 2, 3],
                [3, 4, 5],
                null,
                [2],
                [3],
            ],
            [
                [1, 2, 3],
                [-1, 3, 2],
                null,
                [1, 2],
                [2, 3],
            ],
            [
                ['a' => 1, 2, 'c' => 3],
                [3, 4, 5],
                null,
                ['c'],
                [3],
            ],

            // test $strategy
            [
                [new SimpleObject('a'), new SimpleObject('b'), new SimpleObject('c')],
                [new SimpleObject('c'), new SimpleObject('d'), new SimpleObject('e')],
                'prop',
                [2],
                [new SimpleObject('c')],
            ],
        ];
    }
}
