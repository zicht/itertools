<?php

namespace Zicht\ItertoolsTest;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class SortedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider goodSequenceProvider
     */
    public function testGoodKeyCallback(array $arguments, array $expected)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\sorted', $arguments);
        $this->assertInstanceOf('\Zicht\Itertools\lib\SortedIterator', $iterator);
        $iterator->rewind();

        foreach ($expected as $key => $value) {
            $this->assertTrue($iterator->valid(), 'Failure in $iterator->value()');
            $this->assertEquals($key, $iterator->key(), 'Failure in $iterator->key()');
            $this->assertEquals($value, $iterator->current(), 'Failure in $iterator->current()');
            $iterator->next();
        }

        $this->assertFalse($iterator->valid());
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider badArgumentProvider
     */
    public function testBadArgument(array $arguments)
    {
        $iterator = call_user_func_array('\Zicht\Itertools\sorted', $arguments);
    }

    public function goodSequenceProvider()
    {
        $obj = function ($property, $title) {
            return (object)array('prop' => $property, 'title' => $title);
        };

        return array(
            // callback
            array(
                array(function ($a) { return $a; }, array(1, 2, 3)),
                array(1, 2, 3)),
            array(
                array(function ($a) { return $a; }, array(1, 3, 2)),
                array(1, 2, 3)),
            array(
                array(function ($a) { return $a; }, array(2, 1, 3)),
                array(1, 2, 3)),
            array(
                array(function ($a) { return $a; }, array(2, 3, 1)),
                array(1, 2, 3)),
            array(
                array(function ($a) { return $a; }, array(3, 2, 1)),
                array(1, 2, 3)),
            array(
                array(function ($a) { return $a; }, array(3, 1, 2)),
                array(1, 2, 3)),
            // the same key value
            array(
                array(function ($a) { return $a; }, array(1, 2, 1)),
                array(1, 1, 2)),
            array(
                array(function ($o) { return $o->prop; }, array($obj(1, 4), $obj(1, 2), $obj(1, 3))),
                array($obj(1, 4), $obj(1, 2), $obj(1, 3))),
            array(
                array(function ($o) { return $o->prop; }, array($obj(1, 1), $obj(1, 3), $obj(1, 2))),
                array($obj(1, 1), $obj(1, 3), $obj(1, 2))),
            array(
                array(function ($o) { return $o->prop; }, array($obj(1, 1), $obj(2, 1), $obj(1, 2))),
                array($obj(1, 1), $obj(1, 2), $obj(2, 1))),
            // reverse
            array(
                array(function ($a) { return $a; }, array(1, 3, 2), true),
                array(3, 2, 1)),

            // todo: what happens when reverse sorting when keys are
            // the same? --> the items with the same key are *not*
            // reversed.  This is the behavior of python3, see:
            /*
            >>> class obj:
            ...  def __init__(self, key, value):
            ...   self.key = key
            ...   self.value = value
            ...  def __str__(self):
            ...   return '{self.key}:{self.value}'.format(self=self)

            >>> def get_key(item):
            ...  return item.key

            >>> list = [obj(1, 'first 1'), obj(2, 'first 2'), obj(2, 'second 2'), obj(1, 'second 1')]
            >>> [str(i) for i in list]
            ['1:first 1', '2:first 2', '2:second 2', '1:second 1']

            >>> [str(i) for i in sorted(list, key=get_key)]
            ['1:first 1', '1:second 1', '2:first 2', '2:second 2']

            >>> [str(i) for i in sorted(list, key=get_key, reverse=True)]
            ['2:first 2', '2:second 2', '1:first 1', '1:second 1']
            */

            // todo: ensure thare is a test for the above
        );
    }

    public function badArgumentProvider()
    {
        return array(
            array(array(null, array(1, 2, 3))),
            array(array(function () { return 1; }, array(1, 2, 3), 'this is not a boolean')),
        );
    }
}
