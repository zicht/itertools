<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use Zicht\Itertools;
use Zicht\Itertools\reductions;

class SubTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodArgumentProvider
     */
    public function testGoodArguments(array $data, $expected)
    {
        $closure = reductions\sub();
        $this->assertInstanceOf('\Closure', $closure);
        $this->assertEquals($expected, Itertools\iterable($data)->reduce($closure));
    }

    /**
     * Provides sequences with expected results
     *
     * @return array
     */
    public function goodArgumentProvider()
    {
        return [
            [[6, 2, 2], 2],
            [[10.0, 1.5, 1.5], 7.0],
            [['10.5', '1.0', '1.0'], 8.5],

            // mixed types
            [[10, '1.0'], 9.0],
        ];
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @dataProvider badArgumentProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArguments($a, $b)
    {
        $closure = reductions\sub();
        $this->assertInstanceOf('\Closure', $closure);
        $closure($a, $b);
    }

    /**
     * Provides arguments that should result in \InvalidArgumentException
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            // test argument $a
            [null, 42],
            [true, 42],
            ['', 42],
            [[1, 2, 3], 42],
            [(object)[1, 2, 3], 42],

            // test argument $b
            [42, null],
            [42, true],
            [42, ''],
            [42, [1, 2, 3]],
            [42, (object)[1, 2, 3]],
        ];
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
        $this->assertEquals($expected, Itertools\iterable($data)->reduce($closure));
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
        $this->assertEquals($expected, Itertools\iterable($data)->reduce($closure));
    }

    /**
     * Provides tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [['sub'], [10, 2, 3], 5],
        ];
    }
}
