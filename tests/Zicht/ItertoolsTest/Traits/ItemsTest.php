<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;

/**
 * Class ItemsTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class ItemsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test good sequences
     *
     * @param mixed $iterable
     * @param array $expectedList
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expectedList)
    {
        $items = $iterable->items();
        $this->assertTrue(is_array($items));
        $this->assertEquals(sizeof($expectedList), sizeof($items));

        foreach ($items as $pair) {
            list($expectedKey, $expectedValue) = current($expectedList);
            next($expectedList);

            $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $pair);

            $this->assertArrayHasKey(0, $pair);
            $this->assertArrayHasKey('key', $pair);
            $this->assertEquals($expectedKey, $pair->key);
            $this->assertEquals($expectedKey, $pair[0]);
            $this->assertEquals($expectedKey, $pair['key']);

            $this->assertArrayHasKey(1, $pair);
            $this->assertArrayHasKey('value', $pair);
            $this->assertEquals($expectedValue, $pair->value);
            $this->assertEquals($expectedValue, $pair[1]);
            $this->assertEquals($expectedValue, $pair['value']);

            list($key, $value) = $pair;
            $this->assertEquals($expectedKey, $key);
            $this->assertEquals($expectedValue, $value);
        }
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [
                Itertools\iterable([1, 2, 3]),
                [
                    [0, 1],
                    [1, 2],
                    [2, 3],
                ],
            ],
            [
                Itertools\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                [
                    ['a', 1],
                    ['b', 2],
                    ['c', 3],
                ],
            ],
            // duplicate keys
            [
                Itertools\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                [
                    ['a', -1],
                    ['b', -2],
                    ['c', -3],
                    ['a', 1],
                    ['b', 2],
                    ['c', 3],
                ],
            ],
        ];
    }
}
