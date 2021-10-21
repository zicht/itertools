<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class LengthTest extends \PHPUnit_Framework_TestCase
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

        $expected = [0, 0, 3, 0, 3];

        $closure = Mappings::length();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }
}
