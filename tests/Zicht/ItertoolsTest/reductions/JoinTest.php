<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Reductions;
use function Zicht\Itertools\iterable;

class JoinTest extends TestCase
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
        $closure = Reductions::join($glue);
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
            ['', ['a', 'B', 'c'], 'aBc'],
            ['-', ['a', 'B', 'c'], 'a-B-c'],
            [' and ', ['foo', 'Bar'], 'foo and Bar'],
        ];
    }

    /**
     * @param mixed $glue
     *
     * @dataProvider badGlueProvider
     */
    public function testInvalidGlue($glue)
    {
        $this->expectException(\InvalidArgumentException::class);
        Reductions::join($glue);
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
     */
    public function testInvalidArguments($a, $b)
    {
        $this->expectException(\InvalidArgumentException::class);
        $closure = Reductions::join();
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
}
