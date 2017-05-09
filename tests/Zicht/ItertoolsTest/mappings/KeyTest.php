<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

/**
 * Class KeyTest
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class KeyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $data = [
            'foo',
            'key 1' => 'bar',
            'key 2' => 'moo',
            'milk',
        ];

        $expected = [0, 'key 1' => 'key 1', 'key 2' => 'key 2', 1];

        $closure = mappings\key();
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());
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
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->toArray());
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
            [['key'], ['a' => 1, 'b' => 2, 'c' => 3], ['a' => 'a', 'b' => 'b', 'c' => 'c']],
        ];
    }

    /**
     * Test that get_mappings throws an exception when given an unknown mapping
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetInvalidMapping()
    {
        mappings\get_mapping('foo');
    }
}
