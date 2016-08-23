<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait AccumulateTrait
{
    /**
     * @param string|\Closure $closure
     * @return iter\lib\AccumulateIterator
     */
    public function accumulate($closure = 'add')
    {
        return iter\accumulate($this, $closure);
    }
}
