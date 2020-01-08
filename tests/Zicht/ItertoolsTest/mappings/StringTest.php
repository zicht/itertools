<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;
use Zicht\ItertoolsTest\Dummies\ToStringObject;

class StringTest extends \PHPUnit_Framework_TestCase
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

        $closure = mappings\string();
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->values());
    }
}
