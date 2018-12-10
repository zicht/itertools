<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;

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
        $iterator = Itertools\accumulate($iterable, $func);
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
                'add',
                [],
                [],
            ],

            // test different reductions
            [
                new \ArrayIterator([1, 2, 3]),
                'add',
                [0, 1, 2],
                [1, 3, 6]],
            [
                [1, 2, 3],
                'add',
                [0, 1, 2],
                [1, 3, 6]],
            [
                [1, 2, 3],
                'sub',
                [0, 1, 2],
                [1, -1, -4]],
            [
                [1, 2, 3],
                'mul',
                [0, 1, 2],
                [1, 2, 6]],
            [
                [1, 2, 3],
                'min',
                [0, 1, 2],
                [1, 1, 1]],

            [
                [1, 2, 3],
                'max',
                [0, 1, 2],
                [1, 2, 3]],
            [
                [1, 2, 3],
                function ($a, $b) {
                    return $a + $b;
                },
                [0, 1, 2],
                [1, 3, 6]],
            [
                'Foo',
                function ($a, $b) {
                    return $a . $b;
                },
                [0, 1, 2],
                ['F', 'Fo', 'Foo']],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                'add',
                ['a', 'b', 'c'],
                [1, 3, 6]],

            // test specific bug encountered when using an empty MapIterator as input
            [
                Itertools\map(null, []),
                'add',
                [],
                [],
            ],
        ];
    }

    /**
     * @param mixed $iterable
     * @param mixed $func
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($iterable, $func)
    {
        Itertools\accumulate($iterable, $func);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [0, 'add'],
            [1.0, 'add'],
            [[], 0],
            [[], null],
            [[], 'unknown'],
        ];
    }
}
