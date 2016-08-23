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
     * @param string|\Closure $keyStrategy
     * @param bool $reverse
     * @return iter\lib\SortedIterator
     */
    public function sorted($keyStrategy = null, $reverse = false)
    {
        return iter\sorted($keyStrategy, $this, $reverse);
    }
}
