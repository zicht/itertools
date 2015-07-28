<?php

namespace Zicht\Itertools\lib;

use Iterator;

class RepeatIterator implements Iterator
{
    private $mixed;
    private $times;
    private $key;

    public function __construct($mixed, $times)
    {
        $this->mixed = $mixed;
        $this->times = $times;
        $this->key = 0;
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function current()
    {
        return $this->mixed;
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
        return null === $this->times ? true : $this->key < $this->times;
    }
}
