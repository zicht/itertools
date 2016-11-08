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
     * Make an iterator that returns values from this iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param \Closure $strategy Optional, when not specified !empty will be used
     * @return iter\lib\FilterIterator
     */
    public function filter($strategy = null)
    {
        return iter\filter($strategy, $this);
    }
}
