<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
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
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return DifferenceIterator
     */
    public function difference($iterable, $strategy = null)
    {
        return new DifferenceIterator(
            conversions\mixed_to_iterator($this),
            conversions\mixed_to_iterator($iterable),
            conversions\mixed_to_value_getter($strategy)
        );
    }
}
