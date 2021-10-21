<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools;
use function Zicht\Itertools\iterable;

class ValuesTest extends TestCase
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
                iterable([1, 2, 3]),
                [1, 2, 3],
            ],
            [
                iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                [1, 2, 3],
            ],
            // duplicate keys
            [
                iterable(['a' => -1, 'b' => -2, 'c' => -3])->chain(['a' => 1, 'b' => 2, 'c' => 3]),
                [-1, -2, -3, 1, 2, 3],
            ],
            // calling values is recursive
            [
                iterable([iterable([1, 2, 3]), iterable([4, 5, 6])]),
                [[1, 2, 3], [4, 5, 6]],
            ],
        ];
    }
}
