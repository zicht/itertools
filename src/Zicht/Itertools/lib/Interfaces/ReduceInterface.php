<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\ReduceTrait
 */
interface ReduceInterface
{
    /**
     * Reduce an iterator to a single value
     *
     * @param \Closure $closure
     * @param mixed $initializer
     * @return mixed
     *
     * @see Itertools\lib\Traits\ReduceTrait::reduce
     */
    public function reduce(\Closure $closure, $initializer = null);
}
