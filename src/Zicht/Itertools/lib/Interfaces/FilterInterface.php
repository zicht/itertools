<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface FilterInterface
 *
 * @see Itertools\lib\Traits\FilterTrait
 * @package Zicht\Itertools\lib\Interfaces
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
