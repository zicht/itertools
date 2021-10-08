<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

class LengthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Simple test
     */
    public function test()
    {
        $data = [
            null,
            [],
            [1, 2, 3],
            '',
            'foo',
        ];

        $expected = [0, 0, 3, 0, 3];

        $closure = mappings\length();
        $this->assertEquals($expected, Itertools\iterable($data)->map($closure)->values());
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
            [['length'], [null, [], [1, 2, 3], '', 'foo'], [0, 0, 3, 0, 3]],
        ];
    }
}
