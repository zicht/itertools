<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

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

        $closure = mappings\lstrip();
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure, $data)->values());
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

        $closure = mappings\rstrip();
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure, $data)->values());
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

        $closure = mappings\strip();
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure, $data)->values());
    }

    /**
     * @param array $arguments
     * @param array $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGetMapping(array $arguments, array $data, array $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\mappings\get_mapping', $arguments);
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->toArray());
    }

    /**
     * @param array $arguments
     * @param array $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testDeprecatedGetMapping(array $arguments, array $data, array $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\mappings\getMapping', $arguments);
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->toArray());
    }

    /**
     * Provides tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [['ltrim'], ['foo ', ' bar', 'm o o', ' milk '], ['foo ', 'bar', 'm o o', 'milk ']],
            [['lstrip'], ['foo ', ' bar', 'm o o', ' milk '], ['foo ', 'bar', 'm o o', 'milk ']],

            [['rtrim'], ['foo ', ' bar', 'm o o', ' milk '], ['foo', ' bar', 'm o o', ' milk']],
            [['rstrip'], ['foo ', ' bar', 'm o o', ' milk '], ['foo', ' bar', 'm o o', ' milk']],

            [['trim'], ['foo ', ' bar', 'm o o', ' milk '], ['foo', 'bar', 'm o o', 'milk']],
            [['strip'], ['foo ', ' bar', 'm o o', ' milk '], ['foo', 'bar', 'm o o', 'milk']],
        ];
    }
}
