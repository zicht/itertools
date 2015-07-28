<?php

namespace Zicht\Itertools\lib;

class MapIterator extends \MultipleIterator
{
    private $func;
    private $key;

    public function __construct(\Closure $func /* \Iterator $iterable1, \Iterator $iterable2, ... */)
    {
        parent::__construct(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_NUMERIC);
        foreach (array_slice(func_get_args(), 1) as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw \InvalidArgumentException(sprintf('Argument %d must be an iterator'));
            }
            $this->attachIterator($iterable);
        }
        $this->func = $func;
        $this->key = 0;
    }

    public function rewind()
    {
        parent::rewind();
        $this->key = 0;
    }

    public function current()
    {
        return call_user_func_array($this->func, parent::current());
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        parent::next();
        $this->key += 1;
    }
}
