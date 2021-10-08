<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\AccumulateTrait
 */
interface AccumulateInterface
{
    /**
     * Returns an iterator that containing accumulated elements
     *
     * @param string|\Closure $closure
     * @return Itertools\lib\AccumulateIterator
     *
     * @see Itertools\lib\Traits\AccumulateTrait::accumulate
     */
    public function accumulate($closure = 'add');
}
