<?php

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class StringIterator implements \Iterator, \Countable
{
    use CountableTrait;
    use DebugInfoTrait;

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
