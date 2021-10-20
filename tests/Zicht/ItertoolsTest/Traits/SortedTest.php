<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class SortedTest extends TestCase
{
    /**
     * Ensure that the sorting value is computed exactly once per element
     */
    public function testCallbackCount()
    {
        $counter = 0;
        $getSortKey = function ($value, $key) use (&$counter) {
            $counter += 1;
            return $value;
        };
        $data = [1, 3, 5, 2, 4];

        $this->assertEquals([0 => 1, 3 => 2, 1 => 3, 4 => 4, 2 => 5], iterable($data)->sorted($getSortKey)->toArray());
        $this->assertEquals(sizeof($data), $counter);
    }

    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $data, array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = iterable($data)->sorted(...$arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\SortedIterator', $iterator);
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
        $obj = fn($property, $title) => (object)['prop' => $property, 'title' => $title];

        return [
            // callback
            [
                [1, 2, 3],
                [
                    fn($a) => $a,
                ],
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [
                    fn($a) => $a,
                ],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                [1, 3, 2],
                [
                    fn($a) => $a,
                ],
                [0, 2, 1],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'c' => 3, 'b' => 2],
                [
                    fn($a) => $a,
                ],
                ['a', 'b', 'c'],
                [1, 2, 3],
            ],
            [
                [2, 1, 3],
                [
                    fn($a) => $a,
                ],
                [1, 0, 2],
                [1, 2, 3],
            ],
            [
                [2, 3, 1],
                [
                    fn($a) => $a,
                ],
                [2, 0, 1],
                [1, 2, 3],
            ],
            [
                [3, 2, 1],
                [
                    fn($a) => $a,
                ],
                [2, 1, 0],
                [1, 2, 3],
            ],
            [
                [3, 1, 2],
                [
                    fn($a) => $a,
                ],
                [1, 2, 0],
                [1, 2, 3],
            ],
            // the same key value
            [
                [1, 2, 1],
                [
                    fn($a) => $a,
                ],
                [0, 2, 1],
                [1, 1, 2],
            ],
            [
                [$obj(1, 4), $obj(1, 2), $obj(1, 3)],
                [
                    fn($o) => $o->prop,
                ],
                [0, 1, 2],
                [$obj(1, 4), $obj(1, 2), $obj(1, 3)],
            ],
            [
                [$obj(1, 1), $obj(1, 3), $obj(1, 2)],
                [
                    fn($o) => $o->prop,
                ],
                [0, 1, 2],
                [$obj(1, 1), $obj(1, 3), $obj(1, 2)],
            ],
            [
                [$obj(1, 1), $obj(2, 1), $obj(1, 2)],
                [
                    fn($o) => $o->prop,
                ],
                [0, 2, 1],
                [$obj(1, 1), $obj(1, 2), $obj(2, 1)],
            ],
            // reverse
            [
                [1, 3, 2],
                [
                    fn($a) => $a,
                    true,
                ],
                [1, 2, 0],
                [3, 2, 1],
            ],

            /*
              Reverse sorting with keys that have the same value.
              Below is the behavior of python3, see:

            >>> class obj:
            ...  def __init__(self, key, value):
            ...   self.key = key
            ...   self.value = value
            ...  def __str__(self):
            ...   return '{self.key}:{self.value}'.format(self=self)

            >>> def get_key(item):
            ...  return item.key

            >>> list = [obj(1, 'first 1'), obj(2, 'first 2'), obj(2, 'second 2'), obj(1, 'second 1')]
            >>> [str(i) for i in list]
            ['1:first 1', '2:first 2', '2:second 2', '1:second 1']

            >>> [str(i) for i in sorted(list, key=get_key)]
            ['1:first 1', '1:second 1', '2:first 2', '2:second 2']

            >>> [str(i) for i in sorted(list, key=get_key, reverse=True)]
            ['2:first 2', '2:second 2', '1:first 1', '1:second 1']
            */
            [
                [$obj(1, 'first 1'), $obj(2, 'first 2'), $obj(2, 'second 2'), $obj(1, 'second 1')],
                [
                    fn($o) => $o->prop,
                    true,
                ],
                [1, 2, 0, 3],
                [$obj(2, 'first 2'), $obj(2, 'second 2'), $obj(1, 'first 1'), $obj(1, 'second 1')],
            ],

            // use null as value getter, this returns the value itself
            [
                ['a' => 3, 'b' => 1, 'c' => 2],
                [null],
                ['b', 'c', 'a'],
                [1, 2, 3],
            ],

            // the callback should contain both the key (2nd parameter) and the value (1st parameter)
            [
                ['c' => 1, 'b' => 2, 'a' => 3],
                [
                    fn($value, $key) => $key,
                ],
                ['a', 'b', 'c'],
                [3, 2, 1],
            ],
        ];
    }

    /**
     * @expectedException \Error
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        iterable([1, 2, 3])->sorted(...$arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[123]],
            [[true]],

            // Because we are now using `bool $reverse` type annotation, string parameters are converted to a boolean.  Thanks php...
            // [[null, 'this is not a boolean']],
        ];
    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\SortedIterator', $iterable->sorted());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->sorted());
    }
}
