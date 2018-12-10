<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;

class ValuesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expected)
    {
        $this->assertEquals($expected, $iterable->values());
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [
                Itertools\iterable([1, 2, 3]),
                [1, 2, 3],
            ],
            [
                Itertools\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                [1, 2, 3],
            ],
            // duplicate keys
            [
                Itertools\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                [-1, -2, -3, 1, 2, 3],
            ],
            // calling values is recursive
            [
                Itertools\iterable([Itertools\iterable([1, 2, 3]), Itertools\iterable([4, 5, 6])]),
                [[1, 2, 3], [4, 5, 6]],
            ],
        ];
    }
}
