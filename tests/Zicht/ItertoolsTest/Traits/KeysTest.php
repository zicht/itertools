<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools;

class KeysTest extends TestCase
{
    /**
     * @param mixed $iterable
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expected)
    {
        $this->assertEquals($expected, $iterable->keys());
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
                [0, 1, 2],
            ],
            [
                Itertools\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                ['a', 'b', 'c'],
            ],
            // duplicate keys
            [
                Itertools\iterable(['a' => -1, 'b' => -2, 'c' => -3])->chain(['a' => 1, 'b' => 2, 'c' => 3]),
                ['a', 'b', 'c', 'a', 'b', 'c'],
            ],
        ];
    }
}
