<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

class UniqueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\unique', $arguments);
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
    public function goodSequenceProvider()
    {
        return [
            // call WITHOUT $keyStrategy
            [
                [null],
                [],
                [],
            ],
            [
                [[]],
                [],
                [],
            ],
            [
                [[1, 2, 3]],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [[1, 1, 2, 2, 3, 3]],
                [0, 2, 4],
                [1, 2, 3],
            ],
            [
                [[1, 2, 3, 3, 2, 1]],
                [0, 1, 2],
                [1, 2, 3],
            ],

            // call WITH $keyStrategy
            [
                [null, [1, 2, 3]],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [function ($value) {
                    return $value;
                }, [1, 1, 2, 2, 3, 3]],
                [0, 2, 4],
                [1, 2, 3],
            ],
            [
                [function ($value, $key) {
                    return $key;
                }, [1, 2, 3]],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [function ($value, $key) {
                    return 'A';
                }, [1, 2, 3]],
                [0],
                [1],
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\unique', $arguments);
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
            [[0]],
            [[1.0]],
            [[true]],

            // wrong argument count
            [[]],
            [[function ($value) {
                return $value;
            }, [1, 2, 3], 'one argument to many']],
        ];
    }
}
