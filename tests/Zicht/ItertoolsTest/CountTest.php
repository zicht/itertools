<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Zicht\Itertools\lib\CountIterator;

use Zicht\Itertools;

class CountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($start, $step, array $expectedKeys, array $expectedValues)
    {
        $iterator = Itertools\count($start, $step);
        $this->assertInstanceOf('\Zicht\Itertools\lib\CountIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));

        for ($rewindCounter = 0; $rewindCounter < 2; $rewindCounter++) {
            $iterator->rewind();

            for ($index = 0; $index < sizeof($expectedKeys); $index++) {
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
    public function testGoodSequenceForeach($start, $step, array $expectedKeys, array $expectedValues)
    {
        $iterator = Itertools\count($start, $step);
        $this->assertInstanceOf('\Zicht\Itertools\lib\CountIterator', $iterator);
        $this->assertEquals(sizeof($expectedKeys), sizeof($expectedValues));

        for ($rewindCounter = 0; $rewindCounter < 2; $rewindCounter++) {
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
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [0, 0, [0, 1, 2, 3], [0, 0, 0, 0]],
            [0, 1, [0, 1, 2, 3], [0, 1, 2, 3]],
            [0, -1, [0, 1, 2, 3], [0, -1, -2, -3]],
            [0, 3, [0, 1, 2, 3], [0, 3, 6, 9]],
            [0, -3, [0, 1, 2, 3], [0, -3, -6, -9]],
            [2, 1, [0, 1, 2, 3], [2, 3, 4, 5]],
            [2, -1, [0, 1, 2, 3], [2, 1, 0, -1]],

            [0.0, 0.0, [0, 1, 2, 3], [0.0, 0.0, 0.0, 0.0]],
            [0.0, 0.1, [0, 1, 2, 3], [0.0, 0.1, 0.2, 0.3]],
            [0.0, -0.1, [0, 1, 2, 3], [0.0, -0.1, -0.2, -0.3]],
            [0.0, 3.5, [0, 1, 2, 3], [0.0, 3.5, 7.0, 10.5]],
            [0.0, -3.5, [0, 1, 2, 3], [0.0, -3.5, -7.0, -10.5]],
            [2.0, 0.1, [0, 1, 2, 3], [2.0, 2.1, 2.2, 2.3]],
            [2.0, -0.1, [0, 1, 2, 3], [2.0, 1.9, 1.8, 1.7]],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($start, $step)
    {
        Itertools\count($start, $step);
    }

    /**
     * Provides bad sequence tests
     */
    public function badArgumentProvider()
    {
        return [
            ['0', 1],
            [0, '1'],
            [[], 1],
            [0, []],
            [null, 1],
            [0, null],
        ];
    }

    /**
     * The CountIterator is infinite, hence the DebugInfoTrait will block,
     * therefore we provide a special one for the CountIterator
     */
    public function testDebugInfo()
    {
        $count = new CountIterator(0, 1);
        $info = $count->__debugInfo();

        // instead of a count, the string 'infinite' is returned
        $this->assertEquals(['__length__' => 'infinite', 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4], $info);
    }
}
