<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\conversions;

use PHPUnit\Framework\TestCase;
use Zicht\Itertools\util\Conversions;

class MixedToClosureTest extends TestCase
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
        $result = Conversions::mixedToClosure(null);
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
        $result = Conversions::mixedToClosure([MixedToClosureTest::class, 'callMePlease']);
        $this->assertTrue(is_callable($result));
        $this->assertEquals('Thanks for calling', $result('Thanks for calling'));
    }

    /**
     * Test closure input
     */
    public function testClosure()
    {
        $func = fn() => 'this is me';
        $result = Conversions::mixedToClosure($func);
        $this->assertEquals($func, $result);
    }

    /**
     * Unsupported type should result in an exception
     */
    public function testInvalidClosure()
    {
        $this->expectException(\Error::class);
        Conversions::mixedToClosure(123);
    }
}
