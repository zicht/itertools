<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;

class CollapseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expectedKeys
     * @param array $expectedValues
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expectedKeys, array $expectedValues)
    {
        $iterator = Itertools\collapse($iterable);
        $this->assertInstanceOf('\Zicht\Itertools\lib\CollapseIterator', $iterator);
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
            'empty input' => [
                'iterable' => [],
                'expectedKeys' => [],
                'expectedValues' => [],
            ],

            'test collapse' => [
                'iterable' => [[1, 2, 3], [4, 5, 6], [7, 8, 9]],
                'expectedKeys' => [0, 1, 2, 0, 1, 2, 0, 1, 2],
                'expectedValues' => [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],

            'test non-iterable values are ignored' => [
                'iterable' => [['before'], null, ['after']],
                'expectedKeys' => [0, 0],
                'expectedValues' => ['before', 'after'],
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
        $iterator = Itertools\collapse($iterable);
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
