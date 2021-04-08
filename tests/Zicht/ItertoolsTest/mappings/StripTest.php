<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class StripTest extends \PHPUnit_Framework_TestCase
{
    public function testLStrip()
    {
        $data = [
            'foo ',
            ' bar',
            'm o o',
            ' milk ',
        ];

        $expected = ['foo ', 'bar', 'm o o', 'milk '];

        $closure = Mappings::lstrip();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }

    public function testRStrip()
    {
        $data = [
            'foo ',
            ' bar',
            'm o o',
            ' milk ',
        ];

        $expected = ['foo', ' bar', 'm o o', ' milk'];

        $closure = Mappings::rstrip();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }

    public function testStrip()
    {
        $data = [
            'foo ',
            ' bar',
            'm o o',
            ' milk ',
        ];

        $expected = ['foo', 'bar', 'm o o', 'milk'];

        $closure = Mappings::strip();
        $this->assertEquals($expected, iterable($data)->map($closure)->values());
    }
}
