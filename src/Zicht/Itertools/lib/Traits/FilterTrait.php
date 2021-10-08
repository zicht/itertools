<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\FilterIterator;

trait FilterTrait
{
    /**
     * Make an iterator that returns values from this iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return FilterIterator
     */
    public function filter($strategy = null)
    {
        if ($this instanceof \Iterator) {
            $strategy = conversions\mixed_to_value_getter($strategy);
            $isValid = function ($value, $key) use ($strategy) {
                $tempVarPhp54 = $strategy($value, $key);
                return !empty($tempVarPhp54);
            };

            return new FilterIterator($isValid, $this);
        }

        return null;
    }
}
