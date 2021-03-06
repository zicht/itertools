<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

class JsonEncodeTest extends \PHPUnit_Framework_TestCase
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
            'Hello World',
            [null, 1, 1.14, 'Hello World'],
            (object)[null, 1, 1.14, 'Hello World'],
        ];

        $expected = [
            'null',
            '1',
            'true',
            '[]',
            '"Hello World"',
            '[null,1,1.14,"Hello World"]',
            '{"0":null,"1":1,"2":1.14,"3":"Hello World"}',
        ];

        $closure = mappings\json_encode();
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->values());
    }
}
