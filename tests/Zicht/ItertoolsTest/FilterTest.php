<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools as iter;

/**
 * Class FilterTest
 *
 * @package Zicht\ItertoolsTest
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test good sequences
     *
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     * @dataProvider goodBackwardsCompatibleSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\filter', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
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
     * Test good sequences on deprecated filterBy
     *
     * @param array $arguments
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodBackwardsCompatibleSequenceProvider
     */
    public function testDeprecatedFilterBy(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\filterBy', array_merge([null], $arguments));
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
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
     */
    public function goodBackwardsCompatibleSequenceProvider()
    {
        $trueClosure = function () {
            return true;
        };

        $falseClosure = function () {
            return false;
        };

        $isPositiveClosure = function ($value) {
            return 0 < $value;
        };

        $isNegativeClosure = function ($value) {
            return $value < 0;
        };

        return [
            // with closure
            [
                [$trueClosure, [0, -1, 2, -3]],
                [0, 1, 2, 3],
                [0, -1, 2, -3]],
            [
                [$falseClosure, [0, -1, 2, -3]],
                [],
                []],
            [
                [$isPositiveClosure, [0, -1, 2, -3]],
                [2],
                [2]],
            [
                [$isNegativeClosure, [0, -1, 2, -3]],
                [1, 3],
                [-1, -3]],

            // without closure (this uses !empty as a closure)
            [
                [[1, 2, 3]],
                [0, 1, 2],
                [1, 2, 3]],
            [
                [[null, '', 0, '0']],
                [],
                []],
        ];
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        $hasSmallIndex = function ($value, $key) {
            return $key < 3;
        };

        $hasLargeIndex = function ($value, $key) {
            return 3 <= $key;
        };

        return [
            // single iterable using both key and value
            [
                [$hasSmallIndex, ['a', 'b', 'c', 'd', 'e']],
                [0, 1, 2],
                ['a', 'b', 'c'],
            ],
            [
                [$hasLargeIndex, ['a', 'b', 'c', 'd', 'e']],
                [3, 4],
                ['d', 'e'],
            ],
        ];
    }

    /**
     * Test filter using invalid arguments
     *
     * @param array $arguments
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\filter', $arguments);
    }

    /**
     * Test filter using invalid arguments
     *
     * @expectedException \InvalidArgumentException
     */
    public function testDeprecatedFilterByBadArgument()
    {
        iter\filterBy(1, 2, 3, 4);
    }

    /**
     * Provides invalid tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[]],
            [[0]],
            [[1.0]],
            [[true]],
            [[0, []]],
        ];
    }
}
