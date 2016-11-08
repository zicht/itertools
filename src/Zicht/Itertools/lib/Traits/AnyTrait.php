<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait AnyTrait
{
    /**
     * Returns true when one or more element of this iterable is not empty, otherwise returns false
     *
     * When the optional $STRATEGY argument is given, this argument is used to obtain the
     * value which is tested to be empty.
     *
     * > any([0, '', false])
     * false
     *
     * > any([1, null, 3])
     * true
     *
     * @param \Closure $strategy Optional, when not specified !empty will be used
     * @return bool
     */
    public function any($strategy = null)
    {
        return iter\any($strategy, $this);
    }
}
