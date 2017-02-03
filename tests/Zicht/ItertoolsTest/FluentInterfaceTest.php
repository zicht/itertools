<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools as iter;

/**
 * Class FluentInterfaceTest
 *
 * @package Zicht\ItertoolsTest
 */
class FluentInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        // utility functions
        $multiply = function ($value) {
            return $value * 2;
        };
        $isSmall = function ($value) {
            return $value < 10;
        };

        // get iterable
        $originalData = $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        $iterator = iter\iterable($expected);
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
        $iterator = iter\chain($originalData)->map($multiply)->filter($isSmall)->sorted();
        $this->assertInstanceOf('\Zicht\Itertools\lib\SortedIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        // entire chain written without the chaining feature
        $iterator = iter\sorted(null, iter\filter($isSmall, iter\map($multiply, iter\chain($originalData))));
        $this->assertInstanceOf('\Zicht\Itertools\lib\SortedIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());
    }
}
