<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;

class ItemsTest extends \PHPUnit_Framework_TestCase
{
    /**
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
     *
     * @return array
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


    public function testGoodRecursiveSequence()
    {
        $items = Itertools\iterable([Itertools\iterable([1, 2, 3]), Itertools\iterable([4, 5, 6])])->items();
        $this->assertTrue(is_array($items));
        $this->assertEquals(2, sizeof($items));

        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[0]);
        $this->assertEquals(0, $items[0]->key);
        $this->assertTrue(is_array($items[0]->value));
        $this->assertEquals(3, sizeof($items[0]->value));
        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[0]->value[0]);
        $this->assertEquals(0, $items[0]->value[0]->key);
        $this->assertEquals(1, $items[0]->value[0]->value);
        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[0]->value[1]);
        $this->assertEquals(1, $items[0]->value[1]->key);
        $this->assertEquals(2, $items[0]->value[1]->value);
        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[0]->value[2]);
        $this->assertEquals(2, $items[0]->value[2]->key);
        $this->assertEquals(3, $items[0]->value[2]->value);

        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[1]);
        $this->assertEquals(1, $items[1]->key);
        $this->assertTrue(is_array($items[1]->value));
        $this->assertEquals(3, sizeof($items[1]->value));
        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[1]->value[0]);
        $this->assertEquals(0, $items[1]->value[0]->key);
        $this->assertEquals(4, $items[1]->value[0]->value);
        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[1]->value[1]);
        $this->assertEquals(1, $items[1]->value[1]->key);
        $this->assertEquals(5, $items[1]->value[1]->value);
        $this->assertInstanceOf('Zicht\Itertools\lib\Containers\KeyValuePair', $items[1]->value[2]);
        $this->assertEquals(2, $items[1]->value[2]->key);
        $this->assertEquals(6, $items[1]->value[2]->value);
    }
}
