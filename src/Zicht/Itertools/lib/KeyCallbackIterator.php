<?php

namespace Zicht\Itertools\lib;

// todo: add tests for ArrayAccess

use ArrayAccess;
use IteratorIterator;

/**
 * Class KeyCallbackIterator
 * @package iter
 */
class KeyCallbackIterator extends IteratorIterator implements ArrayAccess
{
    /**
     * @var callable
     */
    private $func;

    /**
     * @param callable $func
     * @param \Iterator $iterable
     */
    public function __construct(\Closure $func, \Iterator $iterable)
    {
        parent::__construct($iterable);
        $this->func = $func;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return call_user_func($this->func, $this->current());
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
