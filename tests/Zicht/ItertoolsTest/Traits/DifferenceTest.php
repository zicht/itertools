<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools as Itertools;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

/**
 * Class DifferenceTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class DifferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $result = Itertools\iterable([1, 2, 3])->difference([3, 4, 5]);
        $this->assertInstanceOf('Zicht\Itertools\lib\DifferenceIterator', $result);
    }

    /**
     * Test good sequences
     *
     * @param mixed $baseIterable
     * @param mixed $compareIterable
     * @param mixed $strategy
     * @param array $expectedKeys
     * @param array $expectedValues
     *
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($baseIterable, $compareIterable, $strategy, array $expectedKeys, array $expectedValues)
    {
        $difference = Itertools\iterable($baseIterable)->difference($compareIterable, $strategy);
        $this->assertEquals($expectedKeys, $difference->keys());
        $this->assertEquals($expectedValues, $difference->values());
    }

    /**
     * Provides good sequence tests
     */
    public function goodSequenceProvider()
    {
        return [
            [
                [],
                [],
                null,
                [],
                [],
            ],
            [
                [1, 2, 3],
                [],
                null,
                [0, 1, 2],
                [1, 2, 3],
            ],
            [
                [],
                [1, 2, 3],
                null,
                [],
                [],
            ],
            [
                [1, 2, 3],
                [3, 4, 5],
                null,
                [0, 1],
                [1, 2],
            ],
            [
                ['a' => 1, 2, 'c' => 3],
                [3, 4, 5],
                null,
                ['a', 0],
                [1, 2],
            ],

            // test $strategy
            [
                [new SimpleObject('a'), new SimpleObject('b'), new SimpleObject('c')],
                [new SimpleObject('c'), new SimpleObject('d'), new SimpleObject('e')],
                'prop',
                [0, 1],
                [new SimpleObject('a'), new SimpleObject('b')],
            ],
        ];
    }
}
