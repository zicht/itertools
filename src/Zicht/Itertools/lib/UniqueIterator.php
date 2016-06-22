<?php

namespace Zicht\Itertools\lib;

use ArrayAccess;
use Closure;
use Countable;
use Iterator;
use FilterIterator as BaseFilterIterator;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class UniqueIterator extends BaseFilterIterator implements Countable, ArrayAccess
{
    use ArrayAccessTrait;
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
        $checkValue = call_user_func($this->func, $this->current(), $this->key());
        if (in_array($checkValue, $this->seen)) {
            return false;
        } else {
            $this->seen [] = $checkValue;
            return true;
        }
    }

    public function rewind()
    {
        $this->seen = array();
        parent::rewind();
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
