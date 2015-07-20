<?php

namespace iter;

use ArrayIterator;
use Closure;
use Iterator;
use IteratorIterator;

class GroupedIterator extends IteratorIterator
{
    protected $key;
    
    public function __construct($key, Iterator $iterable)
    {
        $this->key = $key;
        parent::__construct($iterable);
    }

    public function getKey()
    {
        return $this->key;
    }
}

class GroupbyIterator extends IteratorIterator
{
    public function __construct(Closure $func, Iterator $iterable)
    {
        // todo: this implementation pre-computes everything... this is
        // not the way an iterator should work.  Please re-write.
        $groupedIterator = null;
        $previousKey = null;
        $data = array();

        foreach ($iterable as $value) {
            $key = call_user_func($func, $value);
            if ($previousKey !== $key || $groupedIterator === null) {
                $previousKey = $key;
                $groupedIterator = new GroupedIterator($key, new ArrayIterator());
                $data []= $groupedIterator;
            }
            $groupedIterator->getInnerIterator()->append($value);
        }

        parent::__construct(new ArrayIterator($data));
    }

    public function key()
    {
        return $this->current()->getKey();
    }
}
