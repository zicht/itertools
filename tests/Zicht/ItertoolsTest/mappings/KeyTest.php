<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class KeyTest
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class KeyTest extends PHPUnit_Framework_TestCase
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

        $closure = iter\mappings\key();
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }
}
