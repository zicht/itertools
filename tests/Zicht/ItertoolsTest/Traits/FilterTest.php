<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools as iter;

/**
 * Class FilterTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $result = iter\iterable([1, 2, 3])->filter();
        $this->assertInstanceOf('Zicht\Itertools\lib\FilterIterator', $result);
    }
}
