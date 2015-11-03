<?php

namespace Zicht\Itertools\lib;

use Closure;
use Countable;
use InvalidArgumentException;
use Iterator;
use MultipleIterator;

class MapIterator extends MultipleIterator implements Countable
{
    private $func;
    private $key;

    public function __construct(Closure $func /* \Iterator $iterable1, \Iterator $iterable2, ... */)
    {
        parent::__construct(MultipleIterator::MIT_NEED_ALL| MultipleIterator::MIT_KEYS_NUMERIC);
        foreach (array_slice(func_get_args(), 1) as $iterable) {
            if (!$iterable instanceof Iterator) {
                throw new InvalidArgumentException(sprintf('Argument %d must be an iterator'));
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

    public function toArray()
    {
        return iterator_to_array($this);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return iterator_count($this);
    }
}
