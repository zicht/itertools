<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class ZipTest extends TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expected)
    {
        $iterator = iterable($arguments[0])->zip(...array_slice($arguments, 1));
        $this->assertInstanceOf('\Zicht\Itertools\lib\ZipIterator', $iterator);
        $this->assertEquals(sizeof($iterator), sizeof($expected), 'Failure in sizeof($iterator)');
        $this->assertEquals(iterator_count($iterator), sizeof($expected), 'Failure in iterator_count($iterator)');
        $iterator->rewind();

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($value, $iterator->current(), 'Failure in $iterator->current()');
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
            // single iterable
            [
                [[]],
                [],
            ],
            [
                [[1, 2, 3]],
                [[1], [2], [3]],
            ],
            // double iterable
            [
                [[], []],
                [],
            ],
            [
                [[1, 2, 3], [4, 5, 6]],
                [[1, 4], [2, 5], [3, 6]],
            ],
            // unequal input length
            [
                [[], [4, 5, 6]],
                [],
            ],
            [
                [[1, 2, 3], []],
                [],
            ],
            [
                [[1], [4, 5, 6]],
                [[1, 4]],
            ],
            [
                [[1, 2, 3], [4]],
                [[1, 4]],
            ],
        ];
    }

//    /**
//     * @expectedException \InvalidArgumentException
//     * @dataProvider badArgumentProvider
//     */
//    public function testBadArgumentToFunction(array $arguments)
//    {
//        call_user_func_array('\Zicht\Itertools\zip', $arguments);
//    }
//
//    /**
//     * @expectedException \InvalidArgumentException
//     * @dataProvider badArgumentProvider
//     */
//    public function testBadArgumentToIterator(array $arguments)
//    {
//        $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ZipIterator');
//        $reflectorClass->newInstanceArgs($arguments);
//    }
//
//    /**
//     * Provides bad sequence tests
//     *
//     * @return array
//     */
//    public function badArgumentProvider()
//    {
//        return [
//            [[0]],
//            [[1.0]],
//            [[true]],
//        ];
//    }

    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $iterable = iterable([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\ZipIterator', $iterable->zip());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->zip());
    }
}
