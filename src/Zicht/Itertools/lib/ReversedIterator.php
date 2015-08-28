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
}
