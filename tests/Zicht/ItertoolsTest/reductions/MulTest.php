<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Reductions;
use function Zicht\Itertools\iterable;

class MulTest extends TestCase
{
    /**
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodArgumentProvider
     */
    public function testGoodArguments(array $data, $expected)
    {
        $closure = Reductions::mul();
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
            [[2, -2, 3], -12],
            [[1.5, 1.5, 1.5], 3.375],
            [['1.5', '-1.0', '2.0'], -3.0],

            // mixed types
            [[2, '2.0'], 4.0],
        ];
    }

    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @dataProvider badArgumentProvider
     */
    public function testInvalidArguments($a, $b)
    {
        $this->expectException(\InvalidArgumentException::class);
        $closure = Reductions::mul();
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
