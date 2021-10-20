<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class TypeTest extends TestCase
{
    /**
     * Simple test
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

        $expected = ['NULL', 'integer', 'boolean', 'array', 'string', 'Exception'];

        $closure = Mappings::type();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }

    /**
     * Test with a strategy
     */
    public function testStrategy()
    {
        $data = [
            [
                'key' => 42,
            ],
            [
                'key' => new \Exception('test'),
            ],
        ];

        $expected = ['integer', 'Exception'];

        $closure = Mappings::type('key');
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }
}
