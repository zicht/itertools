<?php

namespace Zicht\ItertoolsTest;

use ArrayIterator;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class AccumulateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodAccmulate($iterable, $func, array $expectedKeys, array $expectedValues)
    {
        $iterator = \Zicht\Itertools\accumulate($iterable, $func);
        $this->assertInstanceOf('\Zicht\Itertools\lib\AccumulateIterator', $iterator);
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

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($iterable, $func)
    {
        $iterator = \Zicht\Itertools\accumulate($iterable, $func);
    }

    public function goodSequenceProvider()
    {
        return array(
            // empty input
            array(
                array(),
                'add',
                array(),
                array(),
            ),

            // test different reductions
            array(
                new ArrayIterator(array(1, 2, 3)),
                'add',
                array(0, 1, 2),
                array(1, 3, 6)),
            array(
                array(1, 2, 3),
                'add',
                array(0, 1, 2),
                array(1, 3, 6)),
            array(
                array(1, 2, 3),
                'sub',
                array(0, 1, 2),
                array(1, -1, -4)),
            array(
                array(1, 2, 3),
                'mul',
                array(0, 1, 2),
                array(1, 2, 6)),
            array(
                array(1, 2, 3),
                'min',
                array(0, 1, 2),
                array(1, 1, 1)),

            array(
                array(1, 2, 3),
                'max',
                array(0, 1, 2),
                array(1, 2, 3)),
            array(
                array(1, 2, 3),
                function ($a, $b) { return $a + $b; },
                array(0, 1, 2),
                array(1, 3, 6)),
            array(
                'Foo',
                function ($a, $b) { return $a . $b; },
                array(0, 1, 2),
                array('F', 'Fo', 'Foo')),
            array(
                array('a' => 1, 'b' => 2, 'c' => 3),
                'add',
                array('a', 'b', 'c'),
                array(1, 3, 6)),

            // test specific bug encountered when using an empty MapIterator as input
            array(
                \Zicht\Itertools\map(null, []),
                'add',
                array(),
                array(),
            ),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(0, 'add'),
            array(1.0, 'add'),
            array(array(), 0),
            array(array(), null),
            array(array(), 'unknown'),
        );
    }
}
