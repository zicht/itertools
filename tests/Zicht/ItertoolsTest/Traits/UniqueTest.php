<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class UniqueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param iterable $data
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProviderWithoutStrategy
     */
    public function testGoodSequenceWithoutStrategy($data, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->unique();
        $this->assertInstanceOf('\Zicht\Itertools\lib\UniqueIterator', $iterator);
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
            [
                [],
                [],
                [],
            ],
            [
                [1, 2, 3],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 1, 2, 2, 3, 3],
                [0, 2, 4],
                [1, 2, 3],
            ],
            [
                [1, 2, 3, 3, 2, 1],
                [0, 1, 2],
                [1, 2, 3],
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
    public function testGoodSequenceWithStrategy($data, $strategy, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->unique($strategy);
        $this->assertInstanceOf('\Zicht\Itertools\lib\UniqueIterator', $iterator);
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
        return [
            [
                null,
                null,
                [],
                [],
            ],
            [
                [1, 2, 3],
                null,
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 1, 2, 2, 3, 3],
                fn($value) => $value,
                [0, 2, 4],
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                fn($value, $key) => $key,
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                fn($value, $key) => 'A',
                [0],
                [1],
            ],
        ];
    }

    /**
     * @param null|string|\Closure $strategy Optional
     * @expectedException \Error
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($strategy)
    {
        iterable([1, 2, 3])->unique($strategy);
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
        $this->assertInstanceOf('Zicht\Itertools\lib\UniqueIterator', $iterable->unique());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->unique());
    }
}
