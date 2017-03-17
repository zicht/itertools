<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface AccumulateInterface
 *
 * @see Itertools\lib\Traits\AccumulateTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface AccumulateInterface
{
    /**
     * Returns an iterator that containing accumulated elements
     *
     * @param string|\Closure $closure
     * @return Itertools\lib\AccumulateIterator
     *
     * @see Itertools\lib\Traits\AccumulateTrait::accumulate
     */
    public function accumulate($closure = 'add');
}
