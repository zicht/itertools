<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait ZipTrait
{
    /**
     * @param array|string|\Iterator $iterable1
     * @param array|string|\Iterator $iterable2
     * @param array|string|\Iterator $iterableN
     * @return iter\lib\ZipIterator
     */
    public function zip(/* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\zip', array_merge([$this], func_get_args()));
    }
}
