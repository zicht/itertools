<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait FilterTrait
{
    /**
     * @param \Closure $closure Optional, when not specified !empty will be used
     * @return iter\lib\FilterIterator
     */
    public function filter($closure = null)
    {
        return iter\filter($closure, $this);
    }
}
