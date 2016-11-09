<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class RandomTest
 *
 * @package Zicht\ItertoolsTest\filters
 */
class RandomTest extends PHPUnit_Framework_TestCase
{
    /**
     * Generate random numbers for every element
     */
    public function test()
    {
        $data = [1, 2, 3];
        $expected = [42, 42, 42];
        $closure = iter\mappings\random(42, 42);
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }

    /**
     * Generate random numbers for every element
     */
    public function testNegative()
    {
        $data = [1, 2, 3];
        $expected = [-42, -42, -42];
        $closure = iter\mappings\random(-42, -42);
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }
}
