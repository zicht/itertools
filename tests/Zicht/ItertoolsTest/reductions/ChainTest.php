<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use Zicht\Itertools;
use Zicht\Itertools\lib\ChainIterator;
use Zicht\Itertools\reductions;

class ChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $lists = [['a' => 1, 'b' => 2, 'c' => 3], ['d' => 4, 'e' => 5, 'f' => 6], ['g' => 7, 'h' => 8, 'i' => 9]];
        $result = Itertools\iterable($lists)->reduce(reductions\chain(), new ChainIterator());
        $this->assertInstanceOf('Zicht\Itertools\lib\ChainIterator', $result);
        $this->assertEquals(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i'], $result->keys());
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->values());
    }

    public function testEmpty()
    {
        $lists = [];
        $result = Itertools\iterable($lists)->reduce(reductions\chain(), new ChainIterator());
        $this->assertInstanceOf('Zicht\Itertools\lib\ChainIterator', $result);
        $this->assertEquals([], $result->keys());
        $this->assertEquals([], $result->values());
    }

    /**
     * The $initializer must be a ChainIterator
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInitializerChainIterator()
    {
        $result = Itertools\iterable([[1, 2, 3], [4, 5, 6]])->reduce(reductions\chain());
        $this->assertInstanceOf('Zicht\Itertools\lib\ChainIterator', $result);
        $result->values();
    }

    /**
     * @param array $arguments
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGetReduction(array $arguments, array $data, $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\reductions\get_reduction', $arguments);
        $this->assertInstanceOf('\Closure', $closure);
        $this->assertEquals($expected, Itertools\iterable($data)->reduce($closure, new ChainIterator())->values());
    }

    /**
     * @param array $arguments
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testDeprecatedGetReduction(array $arguments, array $data, $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\reductions\getReduction', $arguments);
        $this->assertInstanceOf('\Closure', $closure);
        $this->assertEquals($expected, Itertools\iterable($data)->reduce($closure, new ChainIterator())->values());
    }

    /**
     * Provides tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [
                ['chain'],
                [[1, 2, 3], [4, 5, 6]],
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }
}
