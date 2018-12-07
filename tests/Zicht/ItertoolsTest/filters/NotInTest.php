<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use Zicht\Itertools\filters;
use Zicht\Itertools;

class NotInTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple instanceof test
     */
    public function test()
    {
        $filter = filters\not_in(['a', 'b', 'c']);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter('b'));
        $this->assertTrue($filter('e'));
    }

    /**
     * Instanceof test with a specific property
     */
    public function testStrategy()
    {
        $filter = filters\not_in(['a', 'b', 'c'], 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter(['prop' => 'b']));
        $this->assertTrue($filter(['hello world']));
        $this->assertTrue($filter(['prop' => 'Hello world']));
    }


    /**
     * Equals test with strict or non strict
     */
    public function testStrict()
    {
        $filter = filters\not_in([1, 2, 3], null, false);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter(1), 'Non-strict should result in 1 == 1 --> true');
        $this->assertFalse($filter(1.0), 'Non-strict should result in 1 == 1.0 --> true');

        $filter = filters\not_in([1, 2, 3], null, true);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter(1), 'Strict should result in 1 == 1 --> true');
        $this->assertTrue($filter(1.0), 'Strict should result in 1 == 1.0 --> false');
    }

    /**
     * When $haystack is null, this evaluates to an empty $haystack
     */
    public function testHaystackIsNull()
    {
        $filter = filters\not_in(null);
        $this->assertInstanceOf('\Closure', $filter);
        foreach ([null, 1, 'a'] as $value) {
            $this->assertTrue($filter($value));
        }
    }

    /**
     * Ensure that all values in $haystack are used
     *
     * When $haystack is an iterator, any duplicate keys may *not* cause any values to be lost.
     */
    public function testDuplicateKeyInHaystack()
    {
        $filter = filters\not_in(Itertools\chain(['a', 'b', 'c'], ['d', 'e', 'f']));
        $this->assertInstanceOf('\Closure', $filter);
        foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $value) {
            $this->assertFalse($filter($value));
        }
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

        $filter = filters\not_in(['value'], $strategy);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertFalse($filter('value', 'key'));
    }

    /**
     * Should throw exception when invalid arguments are given
     *
     * @param mixed $haystack
     * @param mixed $strategy
     * @param mixed $strict
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentExceptionProvider
     */
    public function testInvalidArgumentException($haystack, $strategy, $strict)
    {
        filters\not_in($haystack, $strategy, $strict);
    }

    /**
     * Provides different invalid arguments
     *
     * @return array
     */
    public function invalidArgumentExceptionProvider()
    {
        return [
            // $haystack must be null|array|string|\Iterator
            [42, null, false],
            [false, null, false],
            [1.5, null, false],

            // $strict must be a boolean
            [['keystack'], null, null],
            [['keystack'], null, []],
            [['keystack'], null, 42],
            [['keystack'], null, 1.5],
            [['keystack'], null, 'invalid'],
        ];
    }
}
