<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\AccumulateIterator;

trait AccumulateTrait
{
    /**
     * Returns an iterator that containing accumulated elements
     *
     * If the optional $closure argument is supplied, it should be a string:
     * add, sub, mul, min, or max.  Or it can be a Closure taking two
     * arguments that will be used to instead of addition.
     *
     * > iter\iterable([1,2,3,4,5])->accumulate(Reductions::add())
     * 1 3 6 10 15
     *
     * > iter\iterable(['One', 'Two', 'Three'])->accumulate(function ($a, $b) { return $a . $b; })
     * 'One' 'OneTwo' 'OneTwoThree'
     *
     * @param \Closure $closure
     */
    public function accumulate(\Closure $closure): ?AccumulateIterator
    {
        if ($this instanceof \Iterator) {
            return new AccumulateIterator($this, $closure);
        }

        return null;
    }
}
