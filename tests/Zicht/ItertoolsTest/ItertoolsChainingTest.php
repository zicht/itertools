<?php

namespace Zicht\ItertoolsTest;

use PHPUnit_Framework_TestCase;
use Zicht\Itertools as iter;

class ItertoolsChainingTest extends PHPUnit_Framework_TestCase
{
    public function testChain()
    {
        $expected = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
        $iterator = iter\chain($expected);
        $this->assertInstanceOf('\Zicht\Itertools\lib\ChainIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        $expected = array(2, 4, 6, 8, 10, 12, 14, 16, 18, 0);
        $iterator = $iterator->map(function ($value) { return $value * 2; });
        $this->assertInstanceOf('\Zicht\Itertools\lib\MapIterator', $iterator);
        $this->assertEquals($expected, $iterator->toArray());

        # todo: add more!
    }
}
