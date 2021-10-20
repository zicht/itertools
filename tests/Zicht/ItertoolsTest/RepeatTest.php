<?php
/**
 * @copyright Zicht Online <https://www.zicht.nl>
 */
/**
namespace Zicht\ItertoolsTest;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools;

class RepeatTest extends TestCase
{
// todo: probably introduce a RepeatTrait and test that
// https://github.com/zicht/itertools/blob/release/2.x/src/Zicht/Itertools/itertools.php#L423
*/
    /**
     * @param mixed $object
     * @param mixed $times
     * @dataProvider goodSequenceProvider
     */
//    public function testGoodSequence($object, $times)
//    {
//        $iterator = Itertools\repeat($object, $times);
//        $this->assertInstanceOf('\Zicht\Itertools\lib\RepeatIterator', $iterator);
//        $this->assertEquals(sizeof($iterator), null === $times ? -1 : $times, 'Failure in $iterator->count() [1]');
//        if (null !== $times) {
//            $this->assertEquals(iterator_count($iterator), $times, 'Failure in $iterator->count() [2]');
//        }
//        $iterator->rewind();
//
//        $actialTestTimes = $times === null ? 2 : $times;
//        for ($key = 0; $key < $actialTestTimes; $key++) {
//            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
//            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
//            $this->assertEquals($object, $iterator->current(), 'Failure in $iterator->current()');
//            $iterator->next();
//        }
//
//        if (null !== $times) {
//            $this->assertFalse($iterator->valid());
//        }
//    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
//    public function goodSequenceProvider()
//    {
//        return [
//            [0, 0],
//            [0, 1],
//            [0, 3],
//            [0, 42],
//            [0, null],
//        ];
//    }

    /**
     * @param mixed $object
     * @param mixed $times
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
//    public function testBadArgument($object, $times)
//    {
//        Itertools\repeat($object, $times);
//    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
//    public function badArgumentProvider()
//    {
//        return [
//            [0, '1'],
//            [0, 1.0],
//            [0, -1],
//            [0, []],
//        ];
//    }
/**}*/
