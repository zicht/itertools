<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $data
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($data, array $expected)
    {
        $this->assertEquals($expected, Itertools\select(null, $data));
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                [1, 2, 3],
            ],
            // duplicate keys
            [
                Itertools\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                [-1, -2, -3, 1, 2, 3],
            ],
        ];
    }

    /**
     * Test select without flattening the result
     */
    public function testWithoutFlatten()
    {
        $data = [1, 2, 3];
        $expected = [1, 2, 3];

        $result = Itertools\select(null, $data, false);
        $this->assertInstanceOf('Zicht\Itertools\lib\MapIterator', $result);
        $this->assertEquals($expected, $result->toArray());
    }

    /**
     * Test select using invalid arguments
     *
     * @expectedException \InvalidArgumentException
     */
    public function testBadArgument()
    {
        Itertools\select('strategy', [], 'wrong-argument');
    }
}
