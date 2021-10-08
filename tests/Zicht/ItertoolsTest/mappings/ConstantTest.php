<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

class ConstantTest extends \PHPUnit_Framework_TestCase
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

        $closure = mappings\constant(42);
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->values());
    }
}
