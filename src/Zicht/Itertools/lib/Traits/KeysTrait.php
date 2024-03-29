<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait KeysTrait
{
    /**
     * Returns an array with keys from this iterator
     */
    public function keys(): array
    {
        $keys = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $keys [] = $key;
            }
        }
        return $keys;
    }
}
