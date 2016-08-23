<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait MapTrait
{
    /**
     * @param \Closure|callable $func
     * @param array|string|\Iterator $iterable1
     * @param array|string|\Iterator $iterable2
     * @param array|string|\Iterator $iterableN
     * @return iter\lib\MapIterator
     */
    public function map($func /* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\map', array_merge([$func, $this], array_slice(func_get_args(), 1)));
    }
}
