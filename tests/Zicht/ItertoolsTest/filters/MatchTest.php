<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Filters;

class MatchTest extends TestCase
{
    /**
     * Simple match test
     */
    public function test()
    {
        $filter = Filters::match('/foo/');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('pre foo post'));
        $this->assertFalse($filter('Hello world'));
    }

    /**
     * Match test with a specific property
     */
    public function testStrategy()
    {
        $filter = Filters::match('/foo/', 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(['prop' => 'pre foo post']));
        $this->assertFalse($filter(['Hello world']));
        $this->assertFalse($filter(['prop' => 'Hello world']));
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

        $filter = Filters::match('/value/', $strategy);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('value', 'key'));
    }

    /**
     * Should throw exception when invalid arguments are given
     *
     * @param mixed $expected
     * @param mixed $strategy
     *
     * @dataProvider invalidArgumentExceptionProvider
     */
    public function testInvalidArgumentException($expected, $strategy)
    {
        $this->expectException(\Error::class);
        Filters::match($expected, $strategy);
    }

    /**
     * Provides different invalid arguments
     *
     * @return array
     */
    public function invalidArgumentExceptionProvider()
    {
        return [
            // $pattern must be a string
            [null, null],
            [1, null],
            [1.2, null],
            [true, null],
        ];
    }
}
