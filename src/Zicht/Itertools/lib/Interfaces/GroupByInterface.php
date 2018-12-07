<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\GroupByTrait
 */
interface GroupByInterface
{
    /**
     * Make an iterator that returns consecutive groups from this
     * iterable.  Generally, this iterable needs to already be sorted on
     * the same key function.
     *
     * @param null|string|\Closure $strategy
     * @param bool $sort
     * @return Itertools\lib\GroupbyIterator
     *
     * @see Itertools\lib\Traits\GroupByTrait::groupBy
     */
    public function groupBy($strategy, $sort = true);
}
