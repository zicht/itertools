<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\reductions;

use Zicht\Itertools\util\Reductions;
use function Zicht\Itertools\iterable;

class MaxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     * @param mixed $expected
     *
     * @dataProvider goodArgumentProvider
     */
    public function testGoodArguments(array $data, $expected)
    {
        $closure = Reductions::max();
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
            [[1, 2, 3], 3],
            [[1.5, -1.5, 1.5], 1.5],
            [['1.5', '1.0', '1.0'], 1.5],

            // mixed types
            [[1, '-1.0'], 1.0],

            // \DateTime types
            [[new \DateTime('2017-11-10 16:23'), new \DateTime('2017-11-09 16:23'), new \DateTime('2017-11-11 16:23')], new \DateTime('2017-11-11 16:23')],
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
        $closure = Reductions::max();
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
