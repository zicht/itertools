<?php

namespace Zicht\ItertoolsTest;

use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class MixedToTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodArguments(array $arguments, array $expected)
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

    public function goodSequenceProvider()
    {
        return array(
            array(
                array(null),
                array(),
            ),
            array(
                array(array(1, 2, 3)),
                array(1, 2, 3)),
            array(
                array(array('a' => 1, 'b' => 2, 'c' => 3)),
                array('a' => 1, 'b' => 2, 'c' => 3)),
            array(
                array('abc'),
                array('a', 'b', 'c')),
            array(
                array(new ArrayCollection(array(1, 2, 3))),
                array(1, 2, 3)),
            array(
                array(new ArrayCollection(array('a' => 1, 'b' => 2, 'c' => 3))),
                array('a' => 1, 'b' => 2, 'c' => 3)),
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArguments(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\mixedToIterator', $arguments);
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(0)),
            array(array(1.0)),
            array(array(true)),
        );
    }
}
