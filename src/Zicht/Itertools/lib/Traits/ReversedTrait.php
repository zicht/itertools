<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait ReversedTrait
{
    /**
     * Returns an iterable with all the elements from this iterable reversed
     *
     * @return iter\lib\ReversedIterator
     */
    public function reversed()
    {
        return iter\reversed($this);
    }
}
