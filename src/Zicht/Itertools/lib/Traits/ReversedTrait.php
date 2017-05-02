<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\ReversedIterator;

trait ReversedTrait
{
    /**
     * Returns an iterable with all the elements from this iterable reversed
     *
     * @return ReversedIterator
     */
    public function reversed()
    {
        if ($this instanceof \Iterator) {
            return new ReversedIterator($this);
        }

        return null;
    }
}
