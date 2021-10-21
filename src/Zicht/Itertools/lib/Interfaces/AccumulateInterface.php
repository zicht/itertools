<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;
use Zicht\Itertools\lib\AccumulateIterator;

/**
 * @see Itertools\lib\Traits\AccumulateTrait
 */
interface AccumulateInterface
{
    /**
     * Returns an iterator that containing accumulated elements
     *
     * @see Itertools\lib\Traits\AccumulateTrait::accumulate
     */
    public function accumulate(\Closure $closure): ?AccumulateIterator;
}
