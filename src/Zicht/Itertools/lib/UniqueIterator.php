<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use Closure;
use Countable;
use Iterator;
use FilterIterator as BaseFilterIterator;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class UniqueIterator extends BaseFilterIterator implements Countable
{
    use CountableTrait;
    use DebugInfoTrait;

    private $func;
    private $seen;

    function __construct(Closure $func, Iterator $iterable)
    {
        $this->func = $func;
        $this->seen = array();
        parent::__construct($iterable);
    }

    public function accept()
    {
        return !in_array(
            call_user_func($this->func, parent::current(), parent::key()),
            $this->seen);
    }

    public function current()
    {
        $value = parent::current();
        $this->seen []= call_user_func($this->func, $value);
        return $value;
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
