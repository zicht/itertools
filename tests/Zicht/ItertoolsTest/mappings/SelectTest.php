<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test with an empty strategies array
     */
    public function testEmptyStrategiesArray()
    {
        $closure = Mappings::select([]);
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
        $closure = Mappings::select((object)[]);
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

        $compute = fn($value, $key) => $value['Value']['Score'] * 2;

        $toObject = fn(array $value) => (object)$value;

        // Test for array
        $closure = Mappings::select(['data' => null, 'id' => 'Identifier', 'desc' => 'Value.Description', 'comp' => $compute]);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test for object
        $closure = Mappings::select((object)['data' => null, 'id' => 'Identifier', 'desc' => 'Value.Description', 'comp' => $compute]);
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());
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

        $toObject = fn(array $value) => (object)$value;

        // Test for array
        // Test *without* using the $strategy = 'field'
        $closure = Mappings::select(['-b-' => 'field.b']);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test using the $strategy = 'field'
        $closure = Mappings::select(['-b-' => 'b'], 'field');
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test for object
        // Test *without* using the $strategy = 'field'
        $closure = Mappings::select((object)['-b-' => 'field.b']);
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());

        // Test using the $strategy = 'field'
        $closure = Mappings::select((object)['-b-' => 'b'], 'field');
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());
    }

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

        $toObject = fn(array $value) => (object)$value;

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
        $closure = Mappings::select(['-b-' => 'b']);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test for object
        $closure = Mappings::select((object)['-b-' => 'b']);
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());

        // Test *with* the $discardNull option
        $expected = [
            [
                '-b-' => 'B1',
            ],
            [],
        ];

        // Test for array
        $closure = Mappings::select(['-b-' => 'b'], null, true);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test for object
        $closure = Mappings::select((object)['-b-' => 'b'], null, true);
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());
    }

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

        $toObject = fn(array $value) => (object)$value;

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
        $closure = Mappings::select(['-b-' => 'b']);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test for object
        $closure = Mappings::select((object)['-b-' => 'b']);
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());

        // test *with* the $discardEmpty option
        $expected = [
            [
                '-b-' => 'B1',
            ],
            [],
        ];

        // Test for array
        $closure = Mappings::select(['-b-' => 'b'], null, false, true);
        $this->assertEquals($expected, iterable($data)->map($closure)->toArray());

        // Test for object
        $closure = Mappings::select((object)['-b-' => 'b'], null, false, true);
        $this->assertEquals(array_map($toObject, $expected), iterable($data)->map($closure)->toArray());
    }
}
