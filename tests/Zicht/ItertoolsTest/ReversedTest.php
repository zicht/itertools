<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;

class ReversedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expectedKeys, array $expectedValues)
    {
        $iterator = Itertools\reversed($iterable);
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
                Itertools\chain([1, 2, 3], [4, 5, 6]),
                [2, 1, 0, 2, 1, 0],
                [6, 5, 4, 3, 2, 1],
            ],
        ];
    }

    /**
     * @param mixed $iterable
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($iterable)
    {
        $iterator = Itertools\reversed($iterable);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [0],
            [1.0],
            [function () {
                return '';
            },
            ],
        ];
    }
}
