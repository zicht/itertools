<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;

trait AnyTrait
{
    /**
     * Returns true when one or more element of this iterable is not empty, otherwise returns false
     *
     * When the optional $STRATEGY argument is given, this argument is used to obtain the
     * value which is tested to be empty.
     *
     * > iterable([0, '', false])->any()
     * false
     *
     * > iterable([1, null, 3])->any()
     * true
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return null|bool
     */
    public function any($strategy = null)
    {
        if ($this instanceof \Iterator) {
            $strategy = conversions\mixed_to_value_getter($strategy);

            foreach ($this as $item) {
                $tempVarPhp54 = call_user_func($strategy, $item);
                if (!empty($tempVarPhp54)) {
                    return true;
                }
            }

            return false;
        }

        return null;
    }
}
