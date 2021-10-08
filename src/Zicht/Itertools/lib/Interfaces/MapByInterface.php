<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\MapByTrait
 */
interface MapByInterface
{
    /**
     * Make an iterator returning values from  this iterable and keys
     * from $strategy.
     *
     * @param null|string|\Closure $strategy
     * @return Itertools\lib\MapByIterator
     *
     * @see Itertools\lib\Traits\MapByTrait::mapBy
     */
    public function mapBy($strategy);
}
