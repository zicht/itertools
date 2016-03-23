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
    protected $groupKey;
    protected $values;

    public function __construct($groupKey)
    {
        $this->groupKey = $groupKey;
        parent::__construct(new ArrayIterator());
    }

    public function getGroupKey()
    {
        return $this->groupKey;
    }

    public function append($key, $value)
    {
        $this->getInnerIterator()->append(array($key, $value));
        // var_dump(['add to' => $this->groupKey, 'key' => $key, 'value' => $value]);
    }

    public function current()
    {
        return $this->getInnerIterator()->current()[1];
    }

    public function key()
    {
        return $this->getInnerIterator()->current()[0];
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

    public function toArray()
    {
        return iterator_to_array($this);
    }
}

class GroupbyIterator extends IteratorIterator implements Countable, ArrayAccess
{
    public function __construct(Closure $func, Iterator $iterable)
    {
        // todo: this implementation pre-computes everything... this is
        // not the way an iterator should work.  Please re-write.
        $groupedIterator = null;
        $previousGroupKey = null;
        $data = array();

        foreach ($iterable as $key => $value) {
            $groupKey = call_user_func($func, $value);
            if ($previousGroupKey !== $groupKey || $groupedIterator === null) {
                $previousGroupKey = $groupKey;
                $groupedIterator = new GroupedIterator($groupKey);
                $data []= $groupedIterator;
            }
            $groupedIterator->append($key, $value);
        }

        parent::__construct(new ArrayIterator($data));
    }

    public function key()
    {
        return $this->current()->getGroupKey();
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

    public function toArray()
    {
        $array = iterator_to_array($this);
        array_walk($array, function (&$value) { $value = $value->toArray(); });
        return $array;
    }
}
