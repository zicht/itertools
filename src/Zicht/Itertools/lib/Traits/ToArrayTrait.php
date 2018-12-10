<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;

trait ToArrayTrait
{
    /**
     * Returns an unsafe array built from this iterator
     *
     * Note that when the iterator contains overlapping keys, that
     * these will be *lost* when converting to an array.
     *
     * A safer option is to use either
     * - $iterable->keys(),
     * - $iterable->values(), or
     * - $iterable->items()
     *
     * @return array
     */
    public function toArray()
    {
        if ($this instanceof \Traversable) {
            $array = iterator_to_array($this);
            array_walk(
                $array,
                function (&$value) {
                    if ($value instanceof FiniteIterableInterface) {
                        $value = $value->toArray();
                    }
                }
            );
            return $array;
        } else {
            return [];
        }
    }
}
