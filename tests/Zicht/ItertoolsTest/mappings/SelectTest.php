<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools;
use Zicht\Itertools\mappings;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test with an empty strategies array
     */
    public function testEmptyStrategiesArray()
    {
        $closure = mappings\select([]);
        $this->assertEquals([], $closure(null, 0));
        $this->assertEquals([], $closure([], 0));
        $this->assertEquals([], $closure('foo', 0));
        $this->assertEquals([], $closure(['foo'], 0));
    }

    /**
     * Test with an empty strategies object
     */
    public function testEmptyStrategiesObject()
    {
        $closure = mappings\select((object)[]);
        $this->assertEquals((object)[], $closure(null, 0));
        $this->assertEquals((object)[], $closure([], 0));
        $this->assertEquals((object)[], $closure('foo', 0));
        $this->assertEquals((object)[], $closure(['foo'], 0));
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

        $toObject = function (array $value) {
            return (object)$value;
        };

        // Test for array
        $closure = mappings\select(['data' => null, 'id' => 'Identifier', 'desc' => 'Value.Description', 'comp' => $compute]);
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test for object
        $closure = mappings\select((object)['data' => null, 'id' => 'Identifier', 'desc' => 'Value.Description', 'comp' => $compute]);
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());
    }

    /**
     * Test the $strategy (singular) parameter
     */
    public function testStrategyParameter()
    {
        $data = [
            [
                'field' => [
                    'a' => 'A1',
                    'b' => 'B1',
                    'c' => 'C1',
                ],
            ],
            [
                'field' => [
                    'a' => 'A2',
                    'b' => 'B2',
                    'c' => 'C2',
                ],
            ],
        ];

        $expected = [
            [
                '-b-' => 'B1',
            ],
            [
                '-b-' => 'B2',
            ],
        ];

        $toObject = function (array $value) {
            return (object)$value;
        };

        // Test for array
        // Test *without* using the $strategy = 'field'
        $closure = mappings\select(['-b-' => 'field.b']);
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test using the $strategy = 'field'
        $closure = mappings\select(['-b-' => 'b'], 'field');
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test for object
        // Test *without* using the $strategy = 'field'
        $closure = mappings\select((object)['-b-' => 'field.b']);
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());

        // Test using the $strategy = 'field'
        $closure = mappings\select((object)['-b-' => 'b'], 'field');
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());
    }

    /**
     * Test the $discardNull parameter
     */
    public function testDiscardNullParameter()
    {
        $data = [
            [
                'a' => null,
                'b' => 'B1',
                'c' => 'C1',
            ],
            [
                'a' => 'A2',
                'b' => null,
                'c' => 'C2',
            ],
        ];

        $toObject = function (array $value) {
            return (object)$value;
        };

        // Test *without* the $discardNull option
        $expected = [
            [
                '-b-' => 'B1',
            ],
            [
                '-b-' => null,
            ],
        ];

        // Test for array
        $closure = mappings\select(['-b-' => 'b']);
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test for object
        $closure = mappings\select((object)['-b-' => 'b']);
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());

        // Test *with* the $discardNull option
        $expected = [
            [
                '-b-' => 'B1',
            ],
            [
            ],
        ];

        // Test for array
        $closure = mappings\select(['-b-' => 'b'], null, true);
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test for object
        $closure = mappings\select((object)['-b-' => 'b'], null, true);
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());
    }

    /**
     * Test the $discardEmpty parameter
     */
    public function testDiscardEmptyParameter()
    {
        $data = [
            [
                'a' => [],
                'b' => 'B1',
                'c' => 'C1',
            ],
            [
                'a' => 'A2',
                'b' => [],
                'c' => 'C2',
            ],
        ];

        $toObject = function (array $value) {
            return (object)$value;
        };

        // Test *without* the $discardEmpty option
        $expected = [
            [
                '-b-' => 'B1',
            ],
            [
                '-b-' => [],
            ],
        ];

        // Test for array
        $closure = mappings\select(['-b-' => 'b']);
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test for object
        $closure = mappings\select((object)['-b-' => 'b']);
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());

        // test *with* the $discardEmpty option
        $expected = [
            [
                '-b-' => 'B1',
            ],
            [
            ],
        ];

        // Test for array
        $closure = mappings\select(['-b-' => 'b'], null, false, true);
        $this->assertEquals($expected, Itertools\map($closure, $data)->toArray());

        // Test for object
        $closure = mappings\select((object)['-b-' => 'b'], null, false, true);
        $this->assertEquals(array_map($toObject, $expected), Itertools\map($closure, $data)->toArray());
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
            [['select', ['a']], [['a' => 1]], [[1]]],
        ];
    }
}
