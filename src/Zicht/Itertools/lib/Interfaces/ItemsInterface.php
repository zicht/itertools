<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface ItemsInterface
 *
 * @see Itertools\lib\Traits\ItemsTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface ItemsInterface
{
    /**
     * Returns an array with items, i.e. [$key, $value] pairs, from this iterator
     *
     * @return array
     *
     * @see Itertools\lib\Traits\ItemsTrait::items
     */
    public function items();
}
