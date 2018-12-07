<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\ChainTrait
 */
interface ChainInterface
{
    /**
     * Returns an iterator that returns elements from the first iterable
     * until it is exhausted, then proceeds to the next iterable, until
     * all the iterables are exhausted.
     *
     * @param array|string|\Iterator $iterable
     * @param array|string|\Iterator $iterable2
     * @return Itertools\lib\ChainIterator
     *
     * @see Itertools\lib\Traits\ChainTrait::chain
     */
    public function chain(/* $iterable, $iterable2, ... */);
}
