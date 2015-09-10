<?php

namespace Zicht\Itertools\lib;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use Iterator;
use IteratorIterator;

// todo: add unit tests for Countable interface
// todo: add unit tests for ArrayAccess interface

class GroupedIterator extends IteratorIterator implements Countable, ArrayAccess
{
    protected $key;

    public function __construct($key, Iterator $iterable)
    {
        $this->key = $key;
        parent::__construct($iterable);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        foreach ($this as $key => $_) {
            if ($key === $offset) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset, $default = null)
    {
        foreach ($this as $key => $value) {
            if ($key === $offset) {
                return $value;
            }
        }
        return $default;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('It is not possible to set iterator values');
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException('It is not possible to unset iterator values');
    }
}

class GroupbyIterator extends IteratorIterator implements Countable
{
    public function __construct(Closure $func, Iterator $iterable)
    {
        // todo: this implementation pre-computes everything... this is
        // not the way an iterator should work.  Please re-write.
        $groupedIterator = null;
        $previousKey = null;
        $data = array();

        foreach ($iterable as $value) {
            $key = call_user_func($func, $value);
            if ($previousKey !== $key || $groupedIterator === null) {
                $previousKey = $key;
                $groupedIterator = new GroupedIterator($key, new ArrayIterator());
                $data []= $groupedIterator;
            }
            $groupedIterator->getInnerIterator()->append($value);
        }

        parent::__construct(new ArrayIterator($data));
    }

    public function key()
    {
        return $this->current()->getKey();
    }

    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }
}
