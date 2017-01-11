<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class LowerTest
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class LowerTest extends PHPUnit_Framework_TestCase
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

        $closure = iter\mappings\lower();
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }
}
