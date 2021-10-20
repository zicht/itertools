<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Filters;
use function Zicht\Itertools\iterable;

class InTest extends TestCase
{
    /**
     * Simple instanceof test
     */
    public function test()
    {
        $filter = Filters::in(['a', 'b', 'c']);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('b'));
        $this->assertFalse($filter('e'));
    }

    /**
     * Instanceof test with a specific property
     */
    public function testStrategy()
    {
        $filter = Filters::in(['a', 'b', 'c'], 'prop');
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(['prop' => 'b']));
        $this->assertFalse($filter(['hello world']));
        $this->assertFalse($filter(['prop' => 'Hello world']));
    }

    /**
     * Equals test with strict or non strict
     */
    public function testStrict()
    {
        $filter = Filters::in([1, 2, 3], null, false);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(1), 'Non-strict should result in 1 == 1 --> true');
        $this->assertTrue($filter(1.0), 'Non-strict should result in 1 == 1.0 --> true');

        $filter = filters::in([1, 2, 3], null, true);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter(1), 'Strict should result in 1 == 1 --> true');
        $this->assertFalse($filter(1.0), 'Strict should result in 1 == 1.0 --> false');
    }

    /**
     * When $haystack is null, this evaluates to an empty $haystack
     */
    public function testHaystackIsNull()
    {
        $filter = Filters::in(null);
        $this->assertInstanceOf('\Closure', $filter);
        foreach ([null, 1, 'a'] as $value) {
            $this->assertFalse($filter($value));
        }
    }

    /**
     * Ensure that all values in $haystack are used
     *
     * When $haystack is an iterator, any duplicate keys may *not* cause any values to be lost.
     */
    public function testDuplicateKeyInHaystack()
    {
        $filter = Filters::in(iterable(['a', 'b', 'c'])->chain(['d', 'e', 'f']));
        $this->assertInstanceOf('\Closure', $filter);
        foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $value) {
            $this->assertTrue($filter($value));
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

        $filter = Filters::in(['value'], $strategy);
        $this->assertInstanceOf('\Closure', $filter);
        $this->assertTrue($filter('value', 'key'));
    }

    /**
     * Should throw exception when invalid arguments are given
     *
     * @param mixed $haystack
     * @param mixed $strategy
     * @param mixed $strict
     *
     * @expectedException \Error
     * @dataProvider invalidArgumentExceptionProvider
     */
    public function testInvalidArgumentException($haystack, $strategy, $strict)
    {
        Filters::in($haystack, $strategy, $strict);
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

            // Because we are now using `bool $strict` type annotation, int, float, and string parameters are converted to a boolean.  Thanks php...
//            [['keystack'], null, 42],
//            [['keystack'], null, 1.5],
//            [['keystack'], null, 'invalid'],
        ];
    }
}
