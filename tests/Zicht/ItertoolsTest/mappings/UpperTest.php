<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Squiz.Arrays.ArrayDeclaration.KeySpecified

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class UpperTest extends TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $data = [
            'FOO',
            'key 1' => 'Bar',
            'key 2' => 'mOo',
            'milk',
        ];

        $expected = ['FOO', 'key 1' => 'BAR', 'key 2' => 'MOO', 'MILK'];

        $closure = Mappings::upper();
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());
    }
}
