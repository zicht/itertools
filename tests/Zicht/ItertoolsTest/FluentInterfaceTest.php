<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use PHPUnit\Framework\TestCase;
use function Zicht\Itertools\iterable;

class FluentInterfaceTest extends TestCase
{
    public function test()
    {
        // utility functions
        $multiply = fn($value) => $value * 2;
        $isSmall = fn($value) => $value < 10;

        // get iterable
        $originalData = $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        $iterator = iterable($expected);
        $this->assertInstanceOf('\Zicht\Itertools\lib\IterableIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        // apply map
        $expected = [2, 4, 6, 8, 10, 12, 14, 16, 18, 0];
        $iterator = $iterator->map($multiply);
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        // apply filter
        $expected = [2, 4, 6, 8, 9 => 0];
        $iterator = $iterator->filter($isSmall);
        $this->assertInstanceOf('\Zicht\Itertools\lib\FilterIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        // apply sorted
        $expected = [9 => 0, 0 => 2, 1 => 4, 2 => 6, 3 => 8];
        $iterator = $iterator->sorted();
        $this->assertInstanceOf('\Zicht\Itertools\lib\SortedIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        # todo: add more!

        // entire chain in one go
        $iterator = iterable($originalData)->map($multiply)->filter($isSmall)->sorted();
        $this->assertInstanceOf('\Zicht\Itertools\lib\SortedIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());
    }
}
