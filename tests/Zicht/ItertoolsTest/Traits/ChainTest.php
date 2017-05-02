<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools;
use Zicht\ItertoolsTest\Dummies\NonIterators\ChainNonIterator;

/**
 * Class ChainTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class ChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $result = Itertools\iterable([1, 2, 3])->chain([4, 5, 6]);
        $this->assertInstanceOf('Zicht\Itertools\lib\ChainIterator', $result);
    }

    /**
     * Test that the trait, when applied to a non-iterator, returns null
     */
    public function testTraitOnNonIterator()
    {
        $nonIterator = new ChainNonIterator();
        $this->assertNull($nonIterator->chain());
    }
}
