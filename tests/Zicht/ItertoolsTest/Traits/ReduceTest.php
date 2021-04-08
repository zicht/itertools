<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools\util\Reductions;
use Zicht\ItertoolsTest\Dummies\NonIterator;
use function Zicht\Itertools\iterable;

class ReduceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $iterable
     * @param string $closure
     * @param mixed $default
     * @param mixed $expected
     * @dataProvider goodSequenceProvider
     */
    public function testGoodSequence($iterable, $closure, $default, $expected)
    {
        $result = iterable($iterable)->reduce($closure, $default);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodSequenceProvider()
    {
        return [
            [[1, 2, 3], Reductions::add(), null, 6],
            [[1, 2, 3], Reductions::sub(), null, -4],
            [[1, 2, 3], Reductions::mul(), null, 6],
            [[1, 2, 3], Reductions::min(), null, 1],
            [[1, 2, 3], Reductions::max(), null, 3],

            // test behavior of default value
            [[], Reductions::add(), null, null],
            [[], Reductions::add(), 2, 2],
            [[1], Reductions::add(), 2, 3],
            [[], Reductions::sub(), 2, 2],
            [[1], Reductions::sub(), 2, 1],

        ];
    }

    /**
     * @param mixed $iterable
     * @param mixed $closure
     * @param mixed $default
     * @expectedException \TypeError
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument($iterable, $closure, $default)
    {
        iterable($iterable)->reduce($closure, $default);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[], 0, null],
            [[], null, null],
            [[], 'unknown', null],
        ];
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->reduce(Reductions::add()));
    }
}
