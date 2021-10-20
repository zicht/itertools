<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class ReversedTest extends TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($iterable)->reversed();
        $this->assertInstanceOf('\Zicht\Itertools\lib\ReversedIterator', $iterator);
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
    public function goodSequenceProvider()
    {
        return [
            // empty input
            [
                [],
                [],
                [],
            ],

            // test simple reversal
            [
                [1, 2, 3],
                [2, 1, 0],
                [3, 2, 1],
            ],

            // test duplicate keys reversal
            [
                iterable([1, 2, 3])->chain([4, 5, 6]),
                [2, 1, 0, 2, 1, 0],
                [6, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\ReversedIterator', $iterable->reversed());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->reversed());
    }
}
