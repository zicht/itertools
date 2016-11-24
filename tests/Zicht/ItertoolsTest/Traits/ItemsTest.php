<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

/**
 * Class ItemsTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class ItemsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test good sequences
     *
     * @param mixed $iterable
     * @param array $expected
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, array $expected)
    {
        $items = $iterable->items();
        $this->assertEquals($expected, $items);
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [
                iter\iterable([1, 2, 3]),
                [
                    new iter\lib\Containers\KeyValuePair(0, 1),
                    new iter\lib\Containers\KeyValuePair(1, 2),
                    new iter\lib\Containers\KeyValuePair(2, 3)
                ]
            ],
            [
                iter\iterable(['a' => 1, 'b' => 2, 'c' => 3]),
                [
                    new iter\lib\Containers\KeyValuePair('a', 1),
                    new iter\lib\Containers\KeyValuePair('b', 2),
                    new iter\lib\Containers\KeyValuePair('c', 3)
                ]
            ],
            // duplicate keys
            [
                iter\chain(['a' => -1, 'b' => -2, 'c' => -3], ['a' => 1, 'b' => 2, 'c' => 3]),
                [
                    new iter\lib\Containers\KeyValuePair('a', -1),
                    new iter\lib\Containers\KeyValuePair('b', -2),
                    new iter\lib\Containers\KeyValuePair('c', -3),
                    new iter\lib\Containers\KeyValuePair('a', 1),
                    new iter\lib\Containers\KeyValuePair('b', 2),
                    new iter\lib\Containers\KeyValuePair('c', 3)
                ]
            ],
        ];
    }
}
