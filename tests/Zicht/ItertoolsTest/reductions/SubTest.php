<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use Zicht\Itertools\util\Reductions;
use function Zicht\Itertools\iterable;

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
        $closure = Reductions::sub();
        $this->assertInstanceOf('\Closure', $closure);
        $this->assertEquals($expected, iterable($data)->reduce($closure));
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
        $closure = Reductions::sub();
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
}
