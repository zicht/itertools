<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use Closure;
use Iterator;
use FilterIterator as BaseFilterIterator;

class FilterIterator extends BaseFilterIterator
{
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
}
