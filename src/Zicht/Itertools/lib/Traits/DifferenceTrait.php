<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\DifferenceIterator;
use Zicht\Itertools\util\Conversions;

trait DifferenceTrait
{
    /**
     * Returns a DifferenceIterator containing elements in $this but not in $iterable
     *
     * @param array|string|\Iterator $iterable
     * @param null|string|\Closure $strategy Optional
     * @return null|DifferenceIterator
     */
    public function difference($iterable, $strategy = null)
    {
        if ($this instanceof \Iterator) {
            return new DifferenceIterator(
                $this,
                Conversions::mixedToIterator($iterable),
                Conversions::mixedToValueGetter($strategy)
            );
        }

        return null;
    }
}
