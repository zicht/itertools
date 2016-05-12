<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use Closure;
use Countable;
use Iterator;
use FilterIterator as BaseFilterIterator;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class FilterIterator extends BaseFilterIterator implements Countable
{
    use CountableTrait;
    use DebugInfoTrait;

    private $func;

    function __construct(Closure $func, Iterator $iterable)
    {
        $this->func = $func;
        parent::__construct($iterable);
    }

    public function accept()
    {
        return call_user_func($this->func, $this->current());
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
