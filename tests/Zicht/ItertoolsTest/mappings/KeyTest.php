<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Squiz.Arrays.ArrayDeclaration.KeySpecified

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class KeyTest extends TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $data = [
            'foo',
            'key 1' => 'bar',
            'key 2' => 'moo',
            'milk',
        ];

        $expected = [0, 'key 1' => 'key 1', 'key 2' => 'key 2', 1];

        $closure = Mappings::key();
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());
    }
}
