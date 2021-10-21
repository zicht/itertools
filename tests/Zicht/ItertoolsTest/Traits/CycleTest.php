<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class CycleTest extends TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($iterable)->cycle();
        $this->assertInstanceOf('\Zicht\Itertools\lib\CycleIterator', $iterator);
        $iterator->rewind();

        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        for ($index = 0; $index < sizeof($expectedKeys); $index++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }
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
                new \ArrayIterator([0, 1, 2]),
                [0, 1, 2, 0, 1, 2, 0],
                [0, 1, 2, 0, 1, 2, 0],
            ],
            [
                ['a' => 0, 'b' => 1, 'c' => 2],
                ['a', 'b', 'c', 'a', 'b', 'c', 'a'],
                [0, 1, 2, 0, 1, 2, 0],
            ],
            [
                new \ArrayIterator([0, -1, -2]),
                [0, 1, 2, 0, 1, 2, 0],
                [0, -1, -2, 0, -1, -2, 0],
            ],
            [
                [0, -1, -2],
                [0, 1, 2, 0, 1, 2, 0],
                [0, -1, -2, 0, -1, -2, 0],
            ],
            [
                new \ArrayIterator([3, 4, 5]),
                [0, 1, 2, 0, 1, 2, 0],
                [3, 4, 5, 3, 4, 5, 3],
            ],
            [
                [3, 4, 5],
                [0, 1, 2, 0, 1, 2, 0],
                [3, 4, 5, 3, 4, 5, 3],
            ],
            [
                new \ArrayIterator([-3, -4, -5]),
                [0, 1, 2, 0, 1, 2, 0],
                [-3, -4, -5, -3, -4, -5, -3],
            ],
            [
                [-3, -4, -5],
                [0, 1, 2, 0, 1, 2, 0],
                [-3, -4, -5, -3, -4, -5, -3],
            ],
            [
                'Foo',
                [0, 1, 2, 0, 1, 2, 0],
                ['F', 'o', 'o', 'F', 'o', 'o', 'F'],
            ],
            // todo: add unicode string test
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\CycleIterator', $iterable->cycle());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->cycle());
    }
}
