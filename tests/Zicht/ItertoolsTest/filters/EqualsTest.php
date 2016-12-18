<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools\filters;

/**
 * Class EqualsTest
 *
 * @package Zicht\ItertoolsTest\filters
 */
class EqualsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Simple equals test
     */
    public function test()
    {
        $filter = filters\equals('foo');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('foo'));
        $this->assertFalse($filter('Hello world'));
    }

    /**
     * Equals test with a specific property
     */
    public function testStrategy()
    {
        $filter = filters\equals('foo', 'prop');
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
        $filter = filters\equals(1, null, false);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(1), 'Non-strict should result in 1 == 1 --> true');
        $this->assertTrue($filter(1.0), 'Non-strict should result in 1 == 1.0 --> true');

        $filter = filters\equals(1, null, true);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(1), 'Strict should result in 1 == 1 --> true');
        $this->assertFalse($filter(1.0), 'Strict should result in 1 == 1.0 --> false');
    }

    /**
     * Should throw exception when invalid arguments are given
     *
     * @param mixed $expected
     * @param mixed $strategy
     * @param mixed $strict
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentExceptionProvider
     */
    public function testInvalidArgumentException($expected, $strategy, $strict)
    {
        filters\equals($expected, $strategy, $strict);
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
