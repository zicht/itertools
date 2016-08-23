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
     * @param \Closure $closure Optional, when not specified !empty will be used
     * @return bool
     */
    public function any($closure = null)
    {
        return iter\any($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }
}
