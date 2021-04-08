<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\ItertoolsTest\Dummies\NonIterator;
use Zicht\ItertoolsTest\Dummies\SimpleObject;
use function Zicht\Itertools\iterable;

class DifferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\DifferenceIterator', $iterable->difference([3, 4, 5]));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->difference([]));
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
        $difference = iterable($baseIterable)->difference($compareIterable, $strategy);
        $this->assertEquals($expectedKeys, $difference->keys());
        $this->assertEquals($expectedValues, $difference->values());
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
                [0, 1, 2],
                [1, 2, 3],
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
                [3, 4, 5],
                null,
                [0, 1],
                [1, 2],
            ],
            [
                ['a' => 1, 2, 'c' => 3],
                [3, 4, 5],
                null,
                ['a', 0],
                [1, 2],
            ],

            // test $strategy
            [
                [new SimpleObject('a'), new SimpleObject('b'), new SimpleObject('c')],
                [new SimpleObject('c'), new SimpleObject('d'), new SimpleObject('e')],
                'prop',
                [0, 1],
                [new SimpleObject('a'), new SimpleObject('b')],
            ],
        ];
    }
}
