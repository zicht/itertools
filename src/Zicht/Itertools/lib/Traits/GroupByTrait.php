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
     * @param string|\Closure $strategy
     * @param bool $sort
     * @return iter\lib\GroupbyIterator
     */
    public function groupBy($strategy, $sort = true)
    {
        return iter\groupBy($strategy, $this, $sort);
    }
}
