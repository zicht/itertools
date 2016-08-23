<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait CycleTrait
{
    /**
     * @return iter\lib\CycleIterator
     */
    public function cycle()
    {
        return iter\cycle($this);
    }
}
