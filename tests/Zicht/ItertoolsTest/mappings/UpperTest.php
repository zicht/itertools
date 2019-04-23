<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

// phpcs:disable Squiz.Arrays.ArrayDeclaration.KeySpecified

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

class UpperTest extends \PHPUnit_Framework_TestCase
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

        $closure = mappings\upper();
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());
    }
}
