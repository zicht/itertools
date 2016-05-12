<?php

namespace Zicht\Itertools\lib;

use ArrayIterator;
use Iterator;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class ReversedIterator extends ArrayIterator
{
    use DebugInfoTrait;

    public function __construct(Iterator $iterable)
    {
        parent::__construct(array_reverse(iterator_to_array($iterable)));
    }
}
