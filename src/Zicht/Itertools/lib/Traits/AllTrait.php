<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\util\Conversions;

trait AllTrait
{
    /**
     * Returns true when all elements of this iterable are not empty, otherwise returns false
     *
     * When the optional $STRATEGY argument is given, this argument is used to obtain the
     * value which is tested to be empty.
     *
     * > iterable([1, 'hello world', true])->all()
     * true
     *
     * > iterable([1, null, 3])->all()
     * false
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return null|bool
     */
    public function all($strategy = null)
    {
        if ($this instanceof \Iterator) {
            $strategy = Conversions::mixedToValueGetter($strategy);

            foreach ($this as $item) {
                $tempVarPhp54 = call_user_func($strategy, $item);
                if (empty($tempVarPhp54)) {
                    return false;
                }
            }

            return true;
        }

        return null;
    }
}
