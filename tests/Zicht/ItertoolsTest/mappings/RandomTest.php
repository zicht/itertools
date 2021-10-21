<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class RandomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Generate random numbers
     */
    public function test()
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expected = ['a' => 42, 'b' => 42, 'c' => 42];
        $closure = Mappings::random(42, 42);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());
    }

    /**
     * Generate negative numbers
     */
    public function testNegative()
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expected = ['a' => -42, 'b' => -42, 'c' => -42];
        $closure = Mappings::random(-42, -42);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());
    }

    /**
     * Generate maximum size numbers
     */
    public function testLargeNumbers()
    {
        $maxrand = getrandmax();
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expected = ['a' => $maxrand, 'b' => $maxrand, 'c' => $maxrand];
        $closure = Mappings::random($maxrand);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());
    }
}
