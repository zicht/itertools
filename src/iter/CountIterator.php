<?php

namespace iter;

class CountIterator implements \Iterator
{
    protected $start;
    protected $step;
    protected $key;
    
    public function __construct($start, $step)
    {
        $this->start = $start;
        $this->step = $step;
        $this->key = 0;
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function current()
    {
        return $this->start + ($this->key * $this->step);
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        $this->key += 1;
    }

    public function valid()
    {
        return true;
    }
}
