<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\ItemsTrait
 */
interface ItemsInterface
{
    /**
     * Returns an array with items, i.e. [$key, $value] pairs, from this iterator
     *
     * @see Itertools\lib\Traits\ItemsTrait::items
     */
    public function items(): array;
}
