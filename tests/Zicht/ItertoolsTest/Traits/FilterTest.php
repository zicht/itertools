<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProviderWithoutStrategy
     */
    public function testGoodSequenceWithoutStrategy(array $data, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->filter();
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($iterator), sizeof($expectedKeys));
        $this->assertEquals(iterator_count($iterator), sizeof($expectedKeys));
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
    public function goodSequenceProviderWithoutStrategy()
    {
        return [
            // without closure (this uses !empty as a closure)
            [
                [1, 2, 3],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [null, '', 0, '0', false, []],
                [],
                [],
            ],
        ];
    }

    /**
     * @param array $data
     * @param null|string|\Closure $strategy Optional
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProviderWithStrategy
     */
    public function testGoodSequenceWithStrategy(array $data, $strategy, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->filter($strategy);
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($iterator), sizeof($expectedKeys));
        $this->assertEquals(iterator_count($iterator), sizeof($expectedKeys));
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
    public function goodSequenceProviderWithStrategy()
    {
        $trueClosure = fn() => true;

        $falseClosure = fn() => false;

        $isPositiveClosure = fn($value) => 0 < $value;

        $isNegativeClosure = fn($value) => $value < 0;

        $hasSmallIndex = fn($value, $key) => $key < 3;

        $hasLargeIndex = fn($value, $key) => 3 <= $key;

        return [
            // with closure
            [
                [0, -1, 2, -3],
                $trueClosure,
                [0, 1, 2, 3],
                [0, -1, 2, -3],
            ],
            [
                [0, -1, 2, -3],
                $falseClosure,
                [],
                [],
            ],
            [
                [0, -1, 2, -3],
                $isPositiveClosure,
                [2],
                [2],
            ],
            [
                [0, -1, 2, -3],
                $isNegativeClosure,
                [1, 3],
                [-1, -3],
            ],

            // single iterable using both key and value
            [
                ['a', 'b', 'c', 'd', 'e'],
                $hasSmallIndex,
                [0, 1, 2],
                ['a', 'b', 'c'],
            ],
            [
                ['a', 'b', 'c', 'd', 'e'],
                $hasLargeIndex,
                [3, 4],
                ['d', 'e'],
            ],
        ];
    }

    /**
     * Test filter using invalid arguments
     *
     * @param mixed $strategy
     * @expectedException \TypeError
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($strategy)
    {
        iterable([1, 2, 3])->filter($strategy);
    }

    /**
     * Provides invalid tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[]],
            [0],
            [1.0],
            [true],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\FilterIterator', $iterable->filter());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->filter());
    }
}
