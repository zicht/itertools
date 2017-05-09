<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface MapInterface
 *
 * @see Itertools\lib\Traits\MapTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface MapInterface
{
    /**
     * Make an iterator that applies $strategy to every entry in this iterable
     *
     * @param null|string|\Closure $strategy
     * @param array|string|\Iterator $iterable2
     * @return Itertools\lib\MapIterator
     *
     * @see Itertools\lib\Traits\MapTrait::map
     */
    public function map($strategy /*, $iterable2, ... */);
}
