<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\FilterIterator;
use Zicht\Itertools\util\Conversions;

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
            $strategy = Conversions::mixedToValueGetter($strategy);
            $isValid = function ($value, $key) use ($strategy) {
                return !empty($strategy($value, $key));
            };

            return new FilterIterator($isValid, $this);
        }

        return null;
    }
}
