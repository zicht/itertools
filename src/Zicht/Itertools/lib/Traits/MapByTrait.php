<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait MapByTrait
{
    /**
     * @param string|\Closure $strategy
     * @return iter\lib\MapByIterator
     */
    public function mapBy($strategy)
    {
        return iter\mapBy($strategy, $this);
    }
}
