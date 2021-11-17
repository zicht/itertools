<?php
/**
 * @copyright Zicht Online <https://www.zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use function Zicht\Itertools\iterable;

class RepeatTest extends TestCase
{
    /**
     * @param mixed $object
     * @param mixed $times
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($object, $times)
    {
        $iterator = iterable($object)->repeat($object, $times);
        $this->assertInstanceOf('\Zicht\Itertools\lib\RepeatIterator', $iterator);
        $this->assertEquals(sizeof($iterator), null === $times ? -1 : $times, 'Failure in $iterator->count() [1]');
        if (null !== $times) {
            $this->assertEquals(iterator_count($iterator), $times, 'Failure in $iterator->count() [2]');
        }
        $iterator->rewind();

        $actualTestTimes = $times === null ? 2 : $times;
        for ($key = 0; $key < $actualTestTimes; $key++) {
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
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [iterable([0]), 0],
            [iterable([0]), 1],
            [iterable([0]), 3],
            [iterable([0]), 42],
            [iterable([0]), null],
        ];
    }

    /**
     * @param mixed $object
     * @param mixed $times
     *
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($object, $times)
    {
        $this->expectException(\InvalidArgumentException::class);
        iterable($object)->repeat($object, $times);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [iterable([0]), '1'],
            [iterable([0]), 1.0],
            [iterable([0]), -1],
            [iterable([0]), 'Z'],
            [iterable([0]), []],
        ];
    }
}
