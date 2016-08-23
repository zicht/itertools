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
     * @param string|\Closure $keyStrategy
     * @return iter\lib\UniqueIterator
     */
    public function unique($keyStrategy = null)
    {
        return iter\unique($keyStrategy, $this);
    }
}
