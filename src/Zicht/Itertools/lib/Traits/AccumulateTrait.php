<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait AccumulateTrait
{
    /**
     * Returns an iterator that containing accumulated elements
     *
     * If the optional $closure argument is supplied, it should be a string:
     * add, sub, mul, min, or max.  Or it can be a Closure taking two
     * arguments that will be used to instead of addition.
     *
     * > iter\iterable([1,2,3,4,5])->accumulate()
     * 1 3 6 10 15
     *
     * > iter\iterable(['One', 'Two', 'Three'])->accumulate(function ($a, $b) { return $a . $b; })
     * 'One' 'OneTwo' 'OneTwoThree'
     *
     * @param string|\Closure $closure
     * @return iter\lib\AccumulateIterator
     */
    public function accumulate($closure = 'add')
    {
        return iter\accumulate($this, $closure);
    }
}
