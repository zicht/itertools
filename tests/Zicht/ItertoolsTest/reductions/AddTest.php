<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Reductions;
use function Zicht\Itertools\iterable;

class AddTest extends TestCase
{
    /**
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodArgumentProvider
     */
    public function testGoodArguments(array $data, $expected)
    {
        $closure = Reductions::add();
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
            [[1, 2, 3], 6],
            [[1.5, 1.5, 1.5], 4.5],
            [['1.5', '1.0', '1.0'], 3.5],

            // mixed types
            [[1, '1.0'], 2.0],
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
        $closure = Reductions::add();
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
