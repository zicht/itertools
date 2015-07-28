<?php

namespace Itertools\lib;

use ArrayIterator;
use Closure;
use Iterator;
use IteratorIterator;

class SortIterator extends IteratorIterator
{
    public function __construct(Closure $func, Iterator $iterable, $reverse = false)
    {
        $data = iterator_to_array($iterable, false);
        usort($data, function ($a, $b) use ($func, $reverse) {
                $keyA = call_user_func($func, $a);
                $keyB = call_user_func($func, $b);

                if ($keyA == $keyB) {
                    return 0;
                } else if ($keyA < $keyB) {
                    return $reverse ? 1 : -1;
                } else {
                    return $reverse ? -1 : 1;
                }
            });

        parent::__construct(new ArrayIterator($data));
    }
}
