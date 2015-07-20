<?php

namespace iter;

class KeyCallbackIterator extends \IteratorIterator
{
    private $func;

    public function __construct(\Closure $func, \Iterator $iterable)
    {
        parent::__construct($iterable);
        $this->func = $func;
    }

    public function key()
    {
        return call_user_func($this->func, $this->current());
    }
}
