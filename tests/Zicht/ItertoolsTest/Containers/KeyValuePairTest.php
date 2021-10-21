<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\lib\Containers\KeyValuePair;

class KeyValuePairTest extends TestCase
{
    /**
     * Tests several ways to access the key and value
     */
    public function testOffsetGet()
    {
        $pair = new KeyValuePair('foo', 'bar');

        // test key access
        $this->assertArrayHasKey(0, $pair);
        $this->assertArrayHasKey('key', $pair);
        $this->assertEquals('foo', $pair->key);
        $this->assertEquals('foo', $pair[0]);
        $this->assertEquals('foo', $pair['key']);

        // test value access
        $this->assertArrayHasKey(1, $pair);
        $this->assertArrayHasKey('value', $pair);
        $this->assertEquals('bar', $pair->value);
        $this->assertEquals('bar', $pair[1]);
        $this->assertEquals('bar', $pair['value']);

        // test list access
        list($key, $value) = $pair;
        $this->assertEquals('foo', $key);
        $this->assertEquals('bar', $value);
    }

    /**
     * Calling OffsetGet with an unknown offset should raise an InvalidArgumentException
     */
    public function testInvalidOffsetGet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $pair = new KeyValuePair('foo', 'bar');
        $pair->offsetGet('invalid');
    }

    /**
     * Tests several ways to set the key and value
     */
    public function testOffsetSet()
    {
        $pair = new KeyValuePair('foo', 'bar');
        $pair[0] = 'foo 0';
        $this->assertEquals('foo 0', $pair->key);
        $pair[1] = 'bar 1';
        $this->assertEquals('bar 1', $pair->value);

        $pair = new KeyValuePair('foo', 'bar');
        $pair['key'] = 'foo key';
        $this->assertEquals('foo key', $pair->key);
        $pair['value'] = 'bar value';
        $this->assertEquals('bar value', $pair->value);
    }

    /**
     * Calling offsetSet with an unknown offset should raise an InvalidArgumentException
     *
     */
    public function testInvalidOffsetSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $pair = new KeyValuePair('foo', 'bar');
        $pair->offsetSet('invalid', 'value');
    }

    /**
     * Tests several ways to unset the key and value
     */
    public function testOffsetUnset()
    {
        $pair = new KeyValuePair('foo', 'bar');
        unset($pair[0]);
        $this->assertEquals(null, $pair->key);
        unset($pair[1]);
        $this->assertEquals(null, $pair->value);

        $pair = new KeyValuePair('foo', 'bar');
        unset($pair['key']);
        $this->assertEquals(null, $pair->key);
        unset($pair['value']);
        $this->assertEquals(null, $pair->value);
    }

    /**
     * Calling offsetUnset with an unknown offset should raise an InvalidArgumentException
     */
    public function testInvalidOffsetUnset()
    {
        $this->expectException(\InvalidArgumentException::class);
        $pair = new KeyValuePair('foo', 'bar');
        unset($pair['invalid']);
    }
}
