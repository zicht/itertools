<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait ChainTrait
{
    /**
     * @param array|string|\Iterator $iterable1
     * @param array|string|\Iterator $iterable2
     * @param array|string|\Iterator $iterableN
     * @return iter\lib\ChainIterator
     */
    public function chain(/* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\chain', array_merge([$this], func_get_args()));
    }
}
