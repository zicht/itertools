<?php

namespace iter;

use Iterator;
use Closure;    

class AccumulateIterator implements Iterator
{
    protected $iterable;
    protected $func;
    protected $key;
    protected $value;

    public function __construct(Iterator $iterable, Closure $func)
    {
        $this->iterable = $iterable;
        $this->func = $func;
    }

    public function rewind()
    {
        $this->key = 0;
        $this->iterable->rewind();
        $this->value = $this->iterable->current();
    }

    public function current()
    {
        return $this->value;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        $this->key += 1;
        $this->iterable->next();
        if ($this->iterable->valid()) {
            // must assign $this->func to $func before calling the closure
            // because otherwise it will try fo find a method called func,
            // which doesn't exist
            $func = $this->func;
            $this->value = $func($this->value, $this->iterable->current());
        }
    }

    public function valid()
    {
        return $this->iterable->valid();
    }
}
