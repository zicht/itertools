<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\filters;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class SelectTest
 *
 * @package Zicht\ItertoolsTest\filters
 */
class SelectTest extends PHPUnit_Framework_TestCase
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
}
