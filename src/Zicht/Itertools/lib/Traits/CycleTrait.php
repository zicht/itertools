<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\CycleIterator;

trait CycleTrait
{
    /**
     * Make an iterator returning elements from this iterable and saving a
     * copy of each.  When the iterable is exhausted, return elements from
     * the saved copy.  Repeats indefinitely.
     *
     * > iterable('ABCD')->cycle()
     * A B C D A B C D A B C D ...
     */
    public function cycle(): ?CycleIterator
    {
        if ($this instanceof \Iterator) {
            return new CycleIterator($this);
        }

        return null;
    }
}
