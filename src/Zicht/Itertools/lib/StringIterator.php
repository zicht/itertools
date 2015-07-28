<?php

namespace Itertools\lib;

class StringIterator implements \Iterator
{
    protected $string;
    protected $key;

    public function __construct($string)
    {
        $this->string = $string;
        $this->key = 0;
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function current()
    {
        return $this->string[$this->key];
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
        return $this->key < strlen($this->string);
    }
}
