<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class ConstantTest extends TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $data = [
            null,
            [],
            [1, 2, 3],
            '',
            'foo',
        ];

        $expected = [42, 42, 42, 42, 42];

        $closure = Mappings::constant(42);
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }
}
