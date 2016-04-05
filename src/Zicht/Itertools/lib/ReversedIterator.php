<?php

namespace Zicht\Itertools\lib;

use ArrayIterator;
use Iterator;

class ReversedIterator extends ArrayIterator
{
    public function __construct(Iterator $iterable)
    {
        parent::__construct(array_reverse(iterator_to_array($iterable)));
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
