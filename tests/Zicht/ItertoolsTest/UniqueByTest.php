<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class UniqueByTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence(array $arguments, array $expectedKeys, array $expectedValues)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\uniqueBy', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\UniqueIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        $this->assertEquals(sizeof($iterator), sizeof($expectedKeys));
        $this->assertEquals(iterator_count($iterator), sizeof($expectedKeys));
        $iterator->rewind();

        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));
        for ($index=0; $index<sizeof($expectedKeys); $index++) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    public function goodSequenceProvider()
    {
        return array(
            // call WITH $keyStrategy
            array(
                array(null, array(1, 2, 3)),
                array(0, 1, 2),
                array(1, 2, 3)
            ),
            array(
                array(function ($value) { return $value; }, array(1, 1, 2, 2, 3, 3)),
                array(0, 2, 4),
                array(1, 2, 3)
            ),
            array(
                array(function ($value, $key) { return $key; }, array(1, 2, 3)),
                array(0, 1, 2),
                array(1, 2, 3)
            ),
            array(
                array(function ($value, $key) { return 'A'; }, array(1, 2, 3)),
                array(0),
                array(1)
            ),
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\uniqueBy', $arguments);
    }

    public function badArgumentProvider()
    {
        return array(
            // wrong types
            array(array(null, 0)),
            array(array(null, 1.0)),
            array(array(null, true)),
            array(array(0, array())),
            array(array(1.0, array())),
            array(array(true, array())),
        );
    }
}
