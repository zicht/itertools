<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;

class ReduceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, $closure, $default, $expected)
    {
        $result = Itertools\reduce($iterable, $closure, $default);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [[1, 2, 3], 'add', null, 6],
            [[1, 2, 3], 'sub', null, -4],
            [[1, 2, 3], 'mul', null, 6],
            [[1, 2, 3], 'min', null, 1],
            [[1, 2, 3], 'max', null, 3],

            // test behavior of default value
            [[], 'add', null, null],
            [[], 'add', 2, 2],
            [[1], 'add', 2, 3],
            [[], 'sub', 2, 2],
            [[1], 'sub', 2, 1],

        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($iterable, $closure, $default)
    {
        Itertools\reduce($iterable, $closure, $default);
    }

    /**
     * Provides bad sequence tests
     */
    public function badArgumentProvider()
    {
        return [
            [0, 'add', null],
            [1.0, 'add', null],
            [true, 'add', null],
            [[], 0, null],
            [[], null, null],
            [[], 'unknown', null],
        ];
    }
}
