<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\Containers\KeyValuePair;
use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;

trait ItemsTrait
{
    /**
     * Returns an array with items, i.e. [$key, $value] pairs, from this iterator
     */
    public function items(): array
    {
        $items = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $items [] = new KeyValuePair($key, $value instanceof FiniteIterableInterface ? $value->items() : $value);
            }
        }
        return $items;
    }
}
