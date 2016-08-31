<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait SortedTrait
{
    /**
     * @param string|\Closure $strategy
     * @param bool $reverse
     * @return iter\lib\SortedIterator
     */
    public function sorted($strategy = null, $reverse = false)
    {
        return iter\sorted($strategy, $this, $reverse);
    }
}
