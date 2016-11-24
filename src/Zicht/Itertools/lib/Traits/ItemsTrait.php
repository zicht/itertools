<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\Containers\KeyValuePair;

trait ItemsTrait
{
    /**
     * Returns an array with items, i.e. [$key, $value] pairs, from this iterator
     *
     * @return array
     */
    public function items()
    {
        $items = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $items [] = new KeyValuePair($key, $value);
            }
        }
        return $items;
    }
}
