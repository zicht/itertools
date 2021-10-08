<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;

trait ValuesTrait
{
    /**
     * Returns an array with values from this iterator
     *
     * @return array
     */
    public function values()
    {
        $values = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $values [] = $value instanceof FiniteIterableInterface ? $value->values() : $value;
            }
        }
        return $values;
    }
}
