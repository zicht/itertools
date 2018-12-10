<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest;

use Doctrine\Common\Collections\ArrayCollection;

class MixedToTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodArgumentProvider
     */
    public function testGoodArgument(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\mixedToIterator', $arguments);
        $this->assertInstanceOf('\Iterator', $iterator);

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->valid()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($value, $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * Provides good sequence tests
     *
     * @return array
     */
    public function goodArgumentProvider()
    {
        return [
            [
                [null],
                [],
            ],
            [
                [[1, 2, 3]],
                [1, 2, 3]],
            [
                [['a' => 1, 'b' => 2, 'c' => 3]],
                ['a' => 1, 'b' => 2, 'c' => 3]],
            [
                ['abc'],
                ['a', 'b', 'c']],
            [
                [new ArrayCollection([1, 2, 3])],
                [1, 2, 3]],
            [
                [new ArrayCollection(['a' => 1, 'b' => 2, 'c' => 3])],
                ['a' => 1, 'b' => 2, 'c' => 3]],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArguments(array $arguments)
    {
        call_user_func_array('\Zicht\Itertools\mixedToIterator', $arguments);
    }

    /**
     * Provides bad sequence tests
     *
     * @return array
     */
    public function badArgumentProvider()
    {
        return [
            [[0]],
            [[1.0]],
            [[true]],
        ];
    }
}
