<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools as iter;

/**
 * Class RandomTest
 *
 * @package Zicht\ItertoolsTest\filters
 */
class RandomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Generate random numbers
     */
    public function test()
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expected = ['a' => 42, 'b' => 42, 'c' => 42];
        $closure = iter\mappings\random(42, 42);
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }

    /**
     * Generate negative numbers
     */
    public function testNegative()
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expected = ['a' => -42, 'b' => -42, 'c' => -42];
        $closure = iter\mappings\random(-42, -42);
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }

    /**
     * Generate maximum size numbers
     */
    public function testLargeNumbers()
    {
        $maxrand = getrandmax();
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expected = ['a' => $maxrand, 'b' => $maxrand, 'c' => $maxrand];
        $closure = iter\mappings\random($maxrand);
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
    }

    /**
     * Test get_mapping
     *
     * @param array $arguments
     * @param array $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGetMapping(array $arguments, array $data, array $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\mappings\get_mapping', $arguments);
        $this->assertEquals($expected, iter\iterable($data)->map($closure)->toArray());
    }

    /**
     * Test deprecated getMapping
     *
     * @param array $arguments
     * @param array $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testDeprecatedGetMapping(array $arguments, array $data, array $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\mappings\getMapping', $arguments);
        $this->assertEquals($expected, iter\iterable($data)->map($closure)->toArray());
    }

    /**
     * Provides tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [['random', 42, 42], [1, 2, 3], [42, 42, 42]],
        ];
    }
}
