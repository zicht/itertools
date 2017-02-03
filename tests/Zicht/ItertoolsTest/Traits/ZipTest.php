<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Traits;

use Zicht\Itertools as iter;

/**
 * Class ZipTest
 *
 * @package Zicht\ItertoolsTest\Traits
 */
class ZipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the trait returns the proper type
     */
    public function testReturnType()
    {
        $result = iter\iterable([1, 2, 3])->zip();
        $this->assertInstanceOf('Zicht\Itertools\lib\ZipIterator', $result);
    }
}
