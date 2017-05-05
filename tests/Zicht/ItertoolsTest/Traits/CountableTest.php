<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\NonIterator;

/**
 * Class CountableTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class CountableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $itetable = Itertools\iterable([1, 2, 3]);
        $this->assertEquals(3, $itetable->count());
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new NonIterator();
        $this->assertNull($nonIterator->count());
    }
}
