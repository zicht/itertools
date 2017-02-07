<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools as iter;

/**
 * Class SelectTest
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test with an empty strategies array
     */
    public function testEmptyStrategies()
    {
        $closure = iter\mappings\select([]);
        $this->assertEquals([], $closure(null, 0));
        $this->assertEquals([], $closure([], 0));
        $this->assertEquals([], $closure('foo', 0));
        $this->assertEquals([], $closure(['foo'], 0));
    }

    /**
     * Test with multiple scenarios
     */
    public function testData()
    {
        $data = [
            [
                'Identifier' => 1,
                'Value' => [
                    'Description' => 'Desc 1',
                    'Score' => 1,
                ],
            ],
            'key 2' => [
                'Identifier' => 2,
                'Value' => [
                    'Description' => 'Desc 2',
                    'Score' => 2,
                ],
            ],
            [
                'Identifier' => 3,
                'Value' => [
                    'Description' => 'Desc 3',
                    'Score' => 3,
                ],
            ],
        ];

        $expected = [
            [
                'data' =>
                    [
                        'Identifier' => 1,
                        'Value' => [
                            'Description' => 'Desc 1',
                            'Score' => 1,
                        ],
                    ],
                'id' => 1,
                'desc' => 'Desc 1',
                'comp' => 2,
            ],
            'key 2' => [
                'data' =>
                    [
                        'Identifier' => 2,
                        'Value' => [
                            'Description' => 'Desc 2',
                            'Score' => 2,
                        ],
                    ],
                'id' => 2,
                'desc' => 'Desc 2',
                'comp' => 4,
            ],
            [
                'data' =>
                    [
                        'Identifier' => 3,
                        'Value' => [
                            'Description' => 'Desc 3',
                            'Score' => 3,
                        ],
                    ],
                'id' => 3,
                'desc' => 'Desc 3',
                'comp' => 6,
            ],
        ];

        $compute = function ($value, $key) {
            return $value['Value']['Score'] * 2;
        };

        $closure = iter\mappings\select(['data' => null, 'id' => 'Identifier', 'desc' => 'Value.Description', 'comp' => $compute]);
        $this->assertEquals($expected, iter\map($closure, $data)->toArray());
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
            [['select', ['a']], [['a' => 1]], [[1]]],
        ];
    }
}
