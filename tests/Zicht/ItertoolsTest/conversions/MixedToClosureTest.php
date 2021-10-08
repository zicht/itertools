<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\conversions;

class MixedToClosureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This method should be called during the testArray test
     *
     * @param mixed $return
     * @return string
     */
    public static function callMePlease($return)
    {
        return $return;
    }

    /**
     * Test NULL input
     */
    public function testNull()
    {
        $result = conversions\mixed_to_closure(null);
        $this->assertTrue(is_callable($result));

        // behaves like the identity function
        foreach (['foo', 42, true] as $value) {
            $this->assertEquals($value, $result($value));
        }
    }

    /**
     * Test array input
     */
    public function testArray()
    {
        $result = conversions\mixed_to_closure([MixedToClosureTest::class, 'callMePlease']);
        $this->assertTrue(is_callable($result));
        $this->assertEquals('Thanks for calling', $result('Thanks for calling'));
    }

    /**
     * Test closure input
     */
    public function testClosure()
    {
        $func = function () {
            return 'this is me';
        };
        $result = conversions\mixed_to_closure($func);
        $this->assertEquals($func, $result);
    }

    /**
     * Unsupported type should result in an exception
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidClosure()
    {
        conversions\mixed_to_closure(123);
    }
}
