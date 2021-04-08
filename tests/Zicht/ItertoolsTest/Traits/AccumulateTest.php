<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools\util\Reductions;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class AccumulateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $iterable
     * @param mixed $func
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, $func, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($iterable)->accumulate($func);
        $this->assertInstanceOf('\Zicht\Itertools\lib\AccumulateIterator', $iterator);
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
                Reductions::add(),
                [],
                [],
            ],

            // test different reductions
            [
                new \ArrayIterator([1, 2, 3]),
                Reductions::add(),
                [0, 1, 2],
                [1, 3, 6],
            ],
            [
                [1, 2, 3],
                Reductions::add(),
                [0, 1, 2],
                [1, 3, 6],
            ],
            [
                [1, 2, 3],
                Reductions::sub(),
                [0, 1, 2],
                [1, -1, -4],
            ],
            [
                [1, 2, 3],
                Reductions::mul(),
                [0, 1, 2],
                [1, 2, 6],
            ],
            [
                [1, 2, 3],
                Reductions::min(),
                [0, 1, 2],
                [1, 1, 1],
            ],

            [
                [1, 2, 3],
                Reductions::max(),
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                fn($a, $b) => $a + $b,
                [0, 1, 2],
                [1, 3, 6],
            ],
            [
                'Foo',
                fn($a, $b) => $a . $b,
                [0, 1, 2],
                ['F', 'Fo', 'Foo'],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                Reductions::add(),
                ['a', 'b', 'c'],
                [1, 3, 6],
            ],

            // test specific bug encountered when using an empty MapIterator as input
            [
                iterable(null)->map(fn($foo) => $foo),
                Reductions::add(),
                [],
                [],
            ],
        ];
    }

    /**
     * @param mixed $func
     * @expectedException \Error
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($func)
    {
        iterable([1, 2, 3])->accumulate($func);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            ['add'],
            [0],
            [null],
            ['unknown'],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\AccumulateIterator', $iterable->accumulate(Reductions::add()));
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->accumulate(Reductions::add()));
    }
}
