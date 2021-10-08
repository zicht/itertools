<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\SortedTrait
 */
interface SortedInterface
{
    /**
     * Make an iterator that returns the values from this iterable
     * sorted by $strategy
     *
     * @param null|string|\Closure $strategy
     * @param bool $reverse
     * @return Itertools\lib\SortedIterator
     *
     * @see Itertools\lib\Traits\SortedTrait::sorted
     */
    public function sorted($strategy = null, $reverse = false);
}
