<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

class CacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the cache key works with uncommon input
     */
    public function test()
    {
        $data = [
            null,
            1,
            true,
            [],
            '',
            new \Exception('test'),
        ];

        $expected = $data;

        $closure = mappings\cache(null);
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->values());
    }

    /**
     * Test that mapping function is not called for cache hits
     */
    public function testStrategy()
    {
        $data = [
            [
                'key' => 42,
                'value' => 42,
            ],
            [
                'key' => 43,
                'value' => 43,
            ],
            [
                'key' => 42,
                'value' => 42 + 666, // Since the 42 key is cached, we should not see this value
            ],
        ];

        $expected = [42, 43, 42];

        $closure = mappings\cache('value', 'key');
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->values());
    }
}
