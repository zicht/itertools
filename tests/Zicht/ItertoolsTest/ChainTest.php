<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

class ChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\chain', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ChainIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($expectedKeys), sizeof($iterator), $iterator);
        $this->assertEquals(sizeof($expectedKeys), iterator_count($iterator));
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
            # data set #0
            [
                [[1, 2, 3], [4, 5, 6], [7, 8, 9]],
                [0, 1, 2, 0, 1, 2, 0, 1, 2],
                [1, 2, 3, 4, 5, 6, 7, 8, 9]],
            # data set #1
            [
                [[1, 2, 3], [], [7, 8, 9]],
                [0, 1, 2, 0, 1, 2],
                [1, 2, 3, 7, 8, 9]],
            # data set #2
            [
                [[1, 2, 3], []],
                [0, 1, 2],
                [1, 2, 3]],
            # data set #3
            [
                [[], [4, 5, 6]],
                [0, 1, 2],
                [4, 5, 6]],
            # data set #4
            [
                [],
                [],
                []],
            # data set #5
            [
                [['a' => 1, 'b' => 2, 'c' => 3], ['d' => 4, 'e' => 5, 'f' => 6]],
                ['a', 'b', 'c', 'd', 'e', 'f'],
                [1, 2, 3, 4, 5, 6]]
            // todo: iterator
            // todo: strings
        ];
    }

    /**
     * @param mixed $iterables
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgumentInFunction($iterables)
    {
        call_user_func_array('\Zicht\Itertools\chain', $iterables);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgumentToIterator(array $arguments)
    {
        $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ChainIterator');
        $reflectorClass->newInstanceArgs($arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[1]],
            [[1.0]],
            [[true]],
        ];
    }
}
