<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\NonIterators\AllNonIterator;

/**
 * Class AllTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class AllTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $result = Itertools\iterable([1, 2, 3])->all();
        $this->assertEquals(true, $result);
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new AllNonIterator();
        $this->assertNull($nonIterator->all());
    }
}
