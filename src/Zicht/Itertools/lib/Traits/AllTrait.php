<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait AllTrait
{
    /**
     * Returns true when all elements of this iterable are not empty, otherwise returns false
     *
     * When the optional $STRATEGY argument is given, this argument is used to obtain the
     * value which is tested to be empty.
     *
     * > iter\iterable([1, 'hello world', true])->all()
     * true
     *
     * > iter\iterable([1, null, 3])->all()
     * false
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return bool
     */
    public function all($strategy = null)
    {
        return iter\all($strategy, $this);
    }
}
