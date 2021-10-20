<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Mappings;
use Zicht\ItertoolsTest\Dummies\ToStringObject;
use function Zicht\Itertools\iterable;

class StringTest extends TestCase
{
    public function test()
    {
        $data = [
            null,
            1,
            true,
            '',
            new ToStringObject('__toString result'),
        ];

        $expected = [
            '',
            '1',
            '1',
            '',
            '__toString result',
        ];

        $closure = Mappings::string();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }
}
