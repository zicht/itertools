<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\lib\CountIterator;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class SliceTest extends TestCase
{
    /**
     * Test using the infinite count iterable
     */
    public function testCombinedWithCountStartingAtZero()
    {
        // [0, 1, 2, 3, ...][0:3] -> [0, 1, 2]
        $iterator = (new CountIterator())->slice(0, 3);
        $this->assertEquals(3, sizeof($iterator));

        $iterator->rewind();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(0, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(0, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(1, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(1, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(2, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(2, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertFalse($iterator->valid(), 'Failure in $iterator->valid()');
    }

    /**
     * Test using the infinite count iterable
     */
    public function testCombinedWithCountStartingAtNonZero()
    {
        // [0, 1, 2, 3, ...][2:5] -> [2, 3, 4]
        $iterator = (new CountIterator())->slice(2, 5);
        $this->assertEquals(3, sizeof($iterator));

        $iterator->rewind();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(2, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(2, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(3, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(3, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
        $this->assertEquals(4, $iterator->key(), 'Failure in $iterator->key()');
        $this->assertEquals(4, $iterator->current(), 'Failure in $iterator->current()');

        $iterator->next();
        $this->assertFalse($iterator->valid(), 'Failure in $iterator->valid()');
    }

    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $data, array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->slice(...$arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\SliceIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues), 'Failure in expected input length');
        $this->assertEquals(sizeof($expectedKeys), sizeof($iterator), 'Failure in input length (a)');
        $this->assertEquals(sizeof($expectedKeys), iterator_count($iterator), 'Failure in input length (b)');

        for ($rewindCounter = 0; $rewindCounter < 2; $rewindCounter++) {
            $iterator->rewind();

            for ($index = 0; $index < sizeof($expectedKeys); $index++) {
                $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
                $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
                $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
                $iterator->next();
            }

            $this->assertFalse($iterator->valid(), 'Failure in $iterator->valid()');
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
            // expect everything returned
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 3],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 99],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],

            // remove the first parts
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [1],
                ['b', 'c'],
                [2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [2],
                ['c'],
                [3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [3],
                [],
                [],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [4],
                [],
                [],
            ],

            // remove the first parts using a negative $begin
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [-1],
                ['c'],
                [3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [-2],
                ['b', 'c'],
                [2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [-3],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [-4],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],

            // remove the last parts
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 4],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 3],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 2],
                ['a', 'b'],
                [1, 2],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 1],
                ['a'],
                [1],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, 0],
                [],
                [],
            ],

            // remove the last parts using a negative $end
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, -1],
                ['a', 'b'],
                [1, 2],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, -2],
                ['a'],
                [1],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, -3],
                [],
                [],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [0, -4],
                [],
                [],
            ],

            // remove the first and last parts
            [
                ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5],
                [1, 4],
                ['b', 'c', 'd'],
                [2, 3, 4],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5],
                [-4, -1],
                ['b', 'c', 'd'],
                [2, 3, 4],
            ],
        ];
    }

    /**
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $this->expectException(\TypeError::class);
        iterable([1, 2, 3])->slice(...$arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [['must-be-integer']],
            [[null]],
            [[0, 'must-be-integer']],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\SliceIterator', $iterable->slice(1));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->slice(1));
    }
}
