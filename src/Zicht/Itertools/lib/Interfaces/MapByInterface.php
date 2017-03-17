<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface MapByInterface
 *
 * @see Itertools\lib\Traits\MapByTrait
 * @package Zicht\Itertools\lib\Interfaces
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
