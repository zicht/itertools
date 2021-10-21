<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class JsonDecodeTest extends TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $data = [
            'null',
            '1',
            'true',
            '[]',
            '"Hello World"',
            '[null,1,1.14,"Hello World"]',
            '{"0":null,"1":1,"2":1.14,"3":"Hello World"}',
        ];

        $expected = [
            null,
            1,
            true,
            [],
            'Hello World',
            [null, 1, 1.14, 'Hello World'],
            (object)[null, 1, 1.14, 'Hello World'],
        ];

        $closure = Mappings::jsonDecode();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }
}
