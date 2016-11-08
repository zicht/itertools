<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait CycleTrait
{
    /**
     * Make an iterator returning elements from this iterable and saving a
     * copy of each.  When the iterable is exhausted, return elements from
     * the saved copy.  Repeats indefinitely.
     *
     * > iter\iterable('ABCD')->cycle()
     * A B C D A B C D A B C D ...
     *
     * @return iter\lib\CycleIterator
     */
    public function cycle()
    {
        return iter\cycle($this);
    }
}
