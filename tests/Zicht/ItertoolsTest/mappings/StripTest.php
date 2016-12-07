<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class StripTest
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class StripTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test lstrip
     */
    public function testLStrip()
    {
        $data = [
            'foo ',
            ' bar',
            'm o o',
            ' milk ',
        ];

        $expected = ['foo ', 'bar', 'm o o', 'milk '];

        $closure = iter\mappings\lstrip();
        $this->assertEquals($expected, iter\iterable($data)->map($closure, $data)->values());
    }

    /**
     * Test rstrip
     */
    public function testRStrip()
    {
        $data = [
            'foo ',
            ' bar',
            'm o o',
            ' milk ',
        ];

        $expected = ['foo', ' bar', 'm o o', ' milk'];

        $closure = iter\mappings\rstrip();
        $this->assertEquals($expected, iter\iterable($data)->map($closure, $data)->values());
    }

    /**
     * Test strip
     */
    public function testStrip()
    {
        $data = [
            'foo ',
            ' bar',
            'm o o',
            ' milk ',
        ];

        $expected = ['foo', 'bar', 'm o o', 'milk'];

        $closure = iter\mappings\strip();
        $this->assertEquals($expected, iter\iterable($data)->map($closure, $data)->values());
    }

    /**
     * Test get_mapping
     *
     * @param array $arguments
     * @param array $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGetMapping(array $arguments, array $data, array $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\mappings\get_mapping', $arguments);
        $this->assertEquals($expected, iter\iterable($data)->map($closure)->toArray());
    }

    /**
     * Test deprecated getMapping
     *
     * @param array $arguments
     * @param array $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testDeprecatedGetMapping(array $arguments, array $data, array $expected)
    {
        $closure = call_user_func_array('\Zicht\Itertools\mappings\getMapping', $arguments);
        $this->assertEquals($expected, iter\iterable($data)->map($closure)->toArray());
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
