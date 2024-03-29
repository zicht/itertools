<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.FunctionComment.ExtraParamComment

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\MapIterator;
use Zicht\Itertools\util\Conversions;

trait MapTrait
{
    /**
     * Make an iterator that applies $strategy to every entry in this iterable
     *
     * If additional iterables are passed, $strategy is called for each entry
     * in the $iterable, where the first argument is the value and the
     * second argument is the key of the entry
     *
     * If additional iterables are passed, $strategy is called with the
     * values and the keys from the iterables. For example, the first
     * call to $strategy will be:
     * $strategy($value_iterable1, $value_iterable2, $key_iterable2, $key_iterable2)
     *
     * With multiple iterables, the iterator stops when the shortest
     * iterable is exhausted.
     *
     * > $minimal = function ($value) { return min(3, $value); };
     * > iter\iterable([1, 2, 3, 4])->map($minimal);
     * 3 3 3 4
     *
     * > $average = function ($value1, $value2) { return ($value1 + $value2) / 2; };
     * > iter\iterable([1, 2, 3])->map($average, [4, 5, 6]);
     * 2.5 3.5 4.5
     *
     * @param null|string|\Closure $strategy
     * @param array[]|string[]|\Iterator[] ...$iterables
     * @return MapIterator
     */
    public function map($strategy, ...$iterables)
    {
        if ($this instanceof \Iterator) {
            if (func_num_args() > 1) {
                $iterables = array_map(
                    function ($iterable) {
                        return Conversions::mixedToIterator($iterable);
                    },
                    $iterables
                );
            }
            $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\MapIterator');
            return $reflectorClass->newInstanceArgs(
                array_merge([Conversions::mixedToValueGetter($strategy), $this], $iterables)
            );
        }

        return null;
    }
}
