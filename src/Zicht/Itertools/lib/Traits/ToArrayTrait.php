<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

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
            return iterator_to_array($this);
        } else {
            return [];
        }
    }
}
