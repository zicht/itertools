<?php

namespace iter;

use InfiniteIterator;

class CycleIterator extends InfiniteIterator
{
    protected $key;

    public function rewind()
    {
        parent::rewind();
        $this->key = 0;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        parent::next();
        $this->key += 1;
    }
}
