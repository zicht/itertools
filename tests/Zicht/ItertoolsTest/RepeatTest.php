<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;

/**
 * Class RepeatTest
 *
 * @package Zicht\ItertoolsTest
 */
class RepeatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($object, $times)
    {
        $iterator = Itertools\repeat($object, $times);
        $this->assertInstanceOf('\Zicht\Itertools\lib\RepeatIterator', $iterator);
        $this->assertEquals(sizeof($iterator), null === $times ? -1 : $times, 'Failure in $iterator->count() [1]');
        if (null !== $times) {
            $this->assertEquals(iterator_count($iterator), $times, 'Failure in $iterator->count() [2]');
        }
        $iterator->rewind();

        $actialTestTimes = $times === null ? 2 : $times;
        for ($key=0; $key<$actialTestTimes; $key++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($object, $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        if (null !== $times) {
            $this->assertFalse($iterator->valid());
        }
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [0, 0],
            [0, 1],
            [0, 3],
            [0, 42],
            [0, null],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($object, $times)
    {
        Itertools\repeat($object, $times);
    }

    /**
     * Provides bad sequence tests
     */
    public function badArgumentProvider()
    {
        return [
            [0, '1'],
            [0, 1.0],
            [0, -1],
            [0, []],
        ];
    }
}
