<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\ReversedIterator;

trait ReversedTrait
{
    /**
     * Returns an iterable with all the elements from this iterable reversed
     */
    public function reversed(): ?ReversedIterator
    {
        if ($this instanceof \Iterator) {
            return new ReversedIterator($this);
        }

        return null;
    }
}
