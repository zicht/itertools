<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools\lib\ChainIterator;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class ChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable()->chain(...$arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ChainIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($expectedKeys), sizeof($iterator), $iterator);
        $this->assertEquals(sizeof($expectedKeys), iterator_count($iterator));
        $iterator->rewind();

        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        for ($index = 0; $index < sizeof($expectedKeys); $index++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            # data set #0
            [
                [[1, 2, 3], [4, 5, 6], [7, 8, 9]],
                [0, 1, 2, 0, 1, 2, 0, 1, 2],
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            # data set #1
            [
                [[1, 2, 3], [], [7, 8, 9]],
                [0, 1, 2, 0, 1, 2],
                [1, 2, 3, 7, 8, 9],
            ],
            # data set #2
            [
                [[1, 2, 3], []],
                [0, 1, 2],
                [1, 2, 3],
            ],
            # data set #3
            [
                [[], [4, 5, 6]],
                [0, 1, 2],
                [4, 5, 6],
            ],
            # data set #4
            [
                [],
                [],
                [],
            ],
            # data set #5
            [
                [['a' => 1, 'b' => 2, 'c' => 3], ['d' => 4, 'e' => 5, 'f' => 6]],
                ['a', 'b', 'c', 'd', 'e', 'f'],
                [1, 2, 3, 4, 5, 6],
            ],
            # data set #6
            [
                [['A'], ['B']],
                [0, 0],
                ['A', 'B'],
            ],
            # data set #7
            [
                [['A'], []],
                [0],
                ['A'],
            ],
            # data set #8
            [
                [[], ['B']],
                [0],
                ['B'],
            ],
            # data set #9
            [
                [['A', 'B', 'C'], ['D', 'E', 'F']],
                [0, 1, 2, 0, 1, 2],
                ['A', 'B', 'C', 'D', 'E', 'F'],
            ],
            # data set #10
            [
                [['A', 'B', 'C'], []],
                [0, 1, 2],
                ['A', 'B', 'C'],
            ],
            # data set #11
            [
                [[], ['D', 'E', 'F']],
                [0, 1, 2],
                ['D', 'E', 'F'],
            ],
            # data set #12
            [
                [['A', 'B', 'C'], ['D', 'E', 'F'], ['G', 'H', 'I']],
                [0, 1, 2, 0, 1, 2, 0, 1, 2],
                ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'],
            ],
            # data set #13
            [
                [new \ArrayIterator([0, 1, 2])],
                [0, 1, 2],
                [0, 1, 2],
            ],
            # data set #14
            [
                [new \ArrayIterator([0, 1, 2]), new \ArrayIterator([3, 4, 5])],
                [0, 1, 2, 0, 1, 2],
                [0, 1, 2, 3, 4, 5],
            ],
            # data set #15
            [
                [new \ArrayIterator([0, 1, 2]), []],
                [0, 1, 2],
                [0, 1, 2],
            ],
            # data set #16
            [
                [[], new \ArrayIterator([3, 4, 5])],
                [0, 1, 2],
                [3, 4, 5],
            ],
            # data set #17
            [
                [new \ArrayIterator([0, 1, 2]), new \ArrayIterator([3, 4, 5]), new \ArrayIterator([6, 7, 8])],
                [0, 1, 2, 0, 1, 2, 0, 1, 2],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
            ],
            # data set #17
            [
                [new \ArrayIterator(['A', 'B', 'C']), new \ArrayIterator(['D', 'E', 'F']), new \ArrayIterator(['G', 'H', 'I'])],
                [0, 1, 2, 0, 1, 2, 0, 1, 2],
                ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'],
            ],
        ];
    }

    /**
     * @param mixed $arguments
     * @expectedException \Error
     * @dataProvider badArgumentProvider
     */
    public function testBadArgumentInFunction($arguments)
    {
        iterable()->chain(...$arguments);
    }

    /**
     * @expectedException \Error
     * @dataProvider badArgumentProvider
     */
    public function testBadArgumentToIterator(array $arguments)
    {
        new ChainIterator(...$arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[1]],
            [[1.0]],
            [[true]],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\ChainIterator', $iterable->chain([4, 5, 6]));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->chain());
    }
}
