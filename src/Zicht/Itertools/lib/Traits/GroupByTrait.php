<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait GroupByTrait
{
    /**
     * @param string|\Closure $keyStrategy
     * @param bool $sort
     * @return iter\lib\GroupbyIterator
     */
    public function groupBy($keyStrategy, $sort = true)
    {
        return iter\groupBy($keyStrategy, $this, $sort);
    }
}
