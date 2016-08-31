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
     * @param \Closure $closure Optional, when not specified !empty will be used
     * @return bool
     */
    public function all($closure = null)
    {
        return iter\all($closure, $this);
    }
}
