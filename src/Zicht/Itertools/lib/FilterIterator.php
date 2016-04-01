<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use Closure;
use Countable;
use Iterator;
use FilterIterator as BaseFilterIterator;

class FilterIterator extends BaseFilterIterator implements Countable
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

    public function toArray()
    {
        return iterator_to_array($this);
    }

    /**
     * This method is called by var_dump() when dumping an object to get the properties that should be shown.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
     * @return array
     */
    public function __debugInfo()
    {
        return iterator_to_array($this);
    }
}
