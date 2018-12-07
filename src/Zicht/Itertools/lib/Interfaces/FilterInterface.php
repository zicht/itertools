<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\FilterTrait
 */
interface FilterInterface
{
    /**
     * Make an iterator that returns values from this iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return Itertools\lib\FilterIterator
     *
     * @see Itertools\lib\Traits\FilterTrait::filter
     */
    public function filter($strategy = null);
}
