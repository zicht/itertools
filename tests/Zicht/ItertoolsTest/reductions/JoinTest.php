<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use Zicht\Itertools;
use Zicht\Itertools\reductions;

class JoinTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $glue
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodArgumentProvider
     */
    public function testGoodArguments($glue, array $data, $expected)
    {
        $closure = reductions\join($glue);
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
            ['', ['a', 'B', 'c'], 'aBc'],
            ['-', ['a', 'B', 'c'], 'a-B-c'],
            [' and ', ['foo', 'Bar'], 'foo and Bar'],
        ];
    }

    /**
     * @param mixed $glue
     *
     * @dataProvider badGlueProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidGlue($glue)
    {
        reductions\join($glue);
    }

    /**
     * Provides invalid glue arguments
     *
     * @return array
     */
    public function badGlueProvider()
    {
        return [
            [null],
            [42],
            [1.0],
            [[1, 2, 3]],
            [(object)[1, 2, 3]],
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
        $closure = reductions\join();
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
            [null, 'bar'],
            [true, 'bar'],
            [42, 'bar'],
            [1.0, 'bar'],
            [[1, 2, 3], 'bar'],
            [(object)[1, 2, 3], 'bar'],

            // test argument $b
            ['foo', null],
            ['foo', true],
            ['foo', 42],
            ['foo', 1.0],
            ['foo', [1, 2, 3]],
            ['foo', (object)[1, 2, 3]],
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
            [['join'], ['a', 'B', 'c'], 'aBc'],
        ];
    }
}
