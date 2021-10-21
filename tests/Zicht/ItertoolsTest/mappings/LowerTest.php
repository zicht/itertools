<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Squiz.Arrays.ArrayDeclaration.KeySpecified

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class LowerTest extends \PHPUnit_Framework_TestCase
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

        $expected = ['foo', 'key 1' => 'bar', 'key 2' => 'moo', 'milk'];

        $closure = Mappings::lower();
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());
    }
}
