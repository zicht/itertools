<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.FunctionComment.ExtraParamComment

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\MapTrait
 */
interface MapInterface
{
    /**
     * Make an iterator that applies $strategy to every entry in this iterable
     *
     * @param null|string|\Closure $strategy
     * @param array|string|\Iterator $iterable
     * @param array|string|\Iterator $iterable2
     * @return Itertools\lib\MapIterator
     *
     * @see Itertools\lib\Traits\MapTrait::map
     */
    public function map($strategy /*, $iterable, $iterable2, ... */);
}
