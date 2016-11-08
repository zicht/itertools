<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait ChainTrait
{
    /**
     * Returns an iterator that returns elements from the first iterable
     * until it is exhausted, then proceeds to the next iterable, until
     * all the iterables are exhausted.
     *
     * Used for creating consecutive sequences as a single sequence.
     *
     * Note that the keys of the returned ChainIterator follow 0, 1, etc,
     * regardless of the keys given in the iterables.
     *
     * > iter\iterable([1, 2, 3], [4, 5, 6])->chain()
     * 1 2 3 4 5 6
     *
     * > iter\iterable('ABC', 'DEF')->chain()
     * A B C D E F
     *
     * @param array|string|\Iterator $iterable
     * @param array|string|\Iterator $iterable2
     * @return iter\lib\ChainIterator
     */
    public function chain(/* $iterable, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\chain', array_merge([$this], func_get_args()));
    }
}
