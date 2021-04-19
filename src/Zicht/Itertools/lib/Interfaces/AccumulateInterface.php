<?php
/**
 * @copyright Zicht Online <https://www.zicht.nl>
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
     * @param \Closure $closure
     * @return Itertools\lib\AccumulateIterator
     *
     * @see Itertools\lib\Traits\AccumulateTrait::accumulate
     */
    public function accumulate(\Closure $closure);
}
