<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class CountTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($start, $step, array $expectedKeys, array $expectedValues)
    {
        $iterator = \Zicht\Itertools\count($start, $step);
        $this->assertInstanceOf('\Zicht\Itertools\lib\CountIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));

        for ($rewindCounter=0; $rewindCounter<2; $rewindCounter++) {
            $iterator->rewind();

            for ($index=0; $index<sizeof($expectedKeys); $index++) {
                $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
                $this->assertEquals($expectedKeys[$index], $iterator->key(), 'Failure in $iterator->key()');
                $this->assertEquals($expectedValues[$index], $iterator->current(), 'Failure in $iterator->current()');
                $iterator->next();
            }
        }
    }

    /**
     * Use foreach to iterate
     *
     * Using foreach or valid(), next(), etc, should always result in the same behavior
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence_foreach($start, $step, array $expectedKeys, array $expectedValues)
    {
        $iterator = \Zicht\Itertools\count($start, $step);
        $this->assertInstanceOf('\Zicht\Itertools\lib\CountIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));

        for ($rewindCounter=0; $rewindCounter<2; $rewindCounter++) {
            $index = 0;
            foreach ($iterator as $key => $value) {
                if (sizeof($expectedValues) <= $index) {
                    break;
                }

                $this->assertEquals($expectedKeys[$index], $key, 'Failure in $key');
                $this->assertEquals($expectedValues[$index], $value, 'Failure in $value');
                $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');

                $index++;
            }
            $this->assertEquals(sizeof($expectedValues), $index);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($start, $step)
    {
        $iterator = \Zicht\Itertools\count($start, $step);
    }

    public function goodSequenceProvider()
    {
        return array(
            array(0, 0, array(0, 1, 2, 3), array(0, 0, 0, 0)),
            array(0, 1, array(0, 1, 2, 3), array(0, 1, 2, 3)),
            array(0, -1, array(0, 1, 2, 3), array(0, -1, -2, -3)),
            array(0, 3, array(0, 1, 2, 3), array(0, 3, 6, 9)),
            array(0, -3, array(0, 1, 2, 3), array(0, -3, -6, -9)),
            array(2, 1, array(0, 1, 2, 3), array(2, 3, 4, 5)),
            array(2, -1, array(0, 1, 2, 3), array(2, 1, 0, -1)),

            array(0.0, 0.0, array(0, 1, 2, 3), array(0.0, 0.0, 0.0, 0.0)),
            array(0.0, 0.1, array(0, 1, 2, 3), array(0.0, 0.1, 0.2, 0.3)),
            array(0.0, -0.1, array(0, 1, 2, 3), array(0.0, -0.1, -0.2, -0.3)),
            array(0.0, 3.5, array(0, 1, 2, 3), array(0.0, 3.5, 7.0, 10.5)),
            array(0.0, -3.5, array(0, 1, 2, 3), array(0.0, -3.5, -7.0, -10.5)),
            array(2.0, 0.1, array(0, 1, 2, 3), array(2.0, 2.1, 2.2, 2.3)),
            array(2.0, -0.1, array(0, 1, 2, 3), array(2.0, 1.9, 1.8, 1.7)),
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array('0', 1),
            array(0, '1'),
            array(array(), 1),
            array(0, array()),
            array(null, 1),
            array(0, null),
        );
    }
}
