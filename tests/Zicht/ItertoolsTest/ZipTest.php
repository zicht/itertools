<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

/**
 * Class ZipTest
 *
 * @package Zicht\ItertoolsTest
 */
class ZipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\zip', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ZipIterator', $iterator);
        $this->assertEquals(sizeof($iterator), sizeof($expected));
        $this->assertEquals(iterator_count($iterator), sizeof($expected));
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
                [[1], [2], [3]]],
            // double iterable
            [
                [[], []],
                [],
            ],
            [
                [[1, 2, 3], [4, 5, 6]],
                [[1, 4], [2, 5], [3, 6]]],
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

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgumentToFunction(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\zip', $arguments);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgumentToIterator(array $arguments)
    {
        $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ZipIterator');
        $reflectorClass->newInstanceArgs($arguments);
    }

    /**
     * Provides bad sequence tests
     */
    public function badArgumentProvider()
    {
        return [
            [[0]],
            [[1.0]],
            [[true]],
        ];
    }
}
