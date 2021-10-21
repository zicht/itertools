<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Filters;

class EqualsTest extends TestCase
{
    /**
     * Simple equals test
     */
    public function test()
    {
        $filter = Filters::equals('foo');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('foo'));
        $this->assertFalse($filter('Hello world'));
    }

    /**
     * Equals test with a specific property
     */
    public function testStrategy()
    {
        $filter = Filters::equals('foo', 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(['prop' => 'foo']));
        $this->assertFalse($filter(['Hello world']));
        $this->assertFalse($filter(['prop' => 'Hello world']));
    }

    /**
     * Equals test with strict or non strict
     */
    public function testStrict()
    {
        $filter = Filters::equals(1, null, false);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(1), 'Non-strict should result in 1 == 1 --> true');
        $this->assertTrue($filter(1.0), 'Non-strict should result in 1 == 1.0 --> true');

        $filter = Filters::equals(1, null, true);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(1), 'Strict should result in 1 == 1 --> true');
        $this->assertFalse($filter(1.0), 'Strict should result in 1 == 1.0 --> false');
    }

    /**
     * The closure must propagate the key to the strategy
     */
    public function testKeyPropagation()
    {
        $strategy = function ($value, $key) {
            $this->assertEquals('value', $value);
            $this->assertEquals('key', $key);
            return $value;
        };

        $filter = Filters::equals('value', $strategy);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('value', 'key'));
    }

    /**
     * Should throw exception when invalid arguments are given
     *
     * @param mixed $expected
     * @param mixed $strategy
     * @param mixed $strict
     *
     * @dataProvider invalidArgumentExceptionProvider
     */
    public function testInvalidArgumentException($expected, $strategy, $strict)
    {
        $this->expectException(\TypeError::class);
        Filters::equals($expected, $strategy, $strict);
    }

    /**
     * Provides different invalid arguments
     *
     * @return array
     */
    public function invalidArgumentExceptionProvider()
    {
        return [
            // $strict must be a boolean
            ['foo', null, null],
            ['foo', null, []],
            ['foo', null, 42],
            ['foo', null, 1.5],
            ['foo', null, 'invalid'],
        ];
    }
}
