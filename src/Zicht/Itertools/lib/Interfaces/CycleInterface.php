<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;
use Zicht\Itertools\lib\CycleIterator;

/**
 * @see Itertools\lib\Traits\CycleTrait
 */
interface CycleInterface
{
    /**
     * Make an iterator returning elements from this iterable and saving a
     * copy of each.  When the iterable is exhausted, return elements from
     * the saved copy.  Repeats indefinitely.
     *
     * @see Itertools\lib\Traits\CycleTrait::cycle
     */
    public function cycle(): ?CycleIterator;
}
