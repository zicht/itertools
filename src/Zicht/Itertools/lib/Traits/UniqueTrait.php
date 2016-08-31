<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait UniqueTrait
{
    /**
     * @param string|\Closure $strategy
     * @return iter\lib\UniqueIterator
     */
    public function unique($strategy = null)
    {
        return iter\unique($strategy, $this);
    }
}
