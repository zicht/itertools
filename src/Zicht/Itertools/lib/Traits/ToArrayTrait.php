<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait ToArrayTrait
{
    /**
     * Returns an unsafe array build from this iterator
     *
     * Note that the resulting array may contain overlapping keys!
     * If this is the case, the resulting array will contain fewer
     * items than the original iterator!
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
