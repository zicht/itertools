<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\DifferenceIterator;

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
                conversions\mixed_to_iterator($iterable),
                conversions\mixed_to_value_getter($strategy)
            );
        }

        return null;
    }
}
