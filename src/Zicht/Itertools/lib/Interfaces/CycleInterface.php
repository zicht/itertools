<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface CycleInterface
 *
 * @see Itertools\lib\Traits\CycleTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface CycleInterface
{
    /**
     * Make an iterator returning elements from this iterable and saving a
     * copy of each.  When the iterable is exhausted, return elements from
     * the saved copy.  Repeats indefinitely.
     *
     * @return Itertools\lib\CycleIterator
     *
     * @see Itertools\lib\Traits\CycleTrait::cycle
     */
    public function cycle();
}
