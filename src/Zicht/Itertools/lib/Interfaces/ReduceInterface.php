<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface ReduceInterface
 *
 * @see Itertools\lib\Traits\ReduceTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface ReduceInterface
{
    /**
     * Reduce an iterator to a single value
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $closure
     * @param mixed $initializer
     * @return mixed
     *
     * @see Itertools\lib\Traits\ReduceTrait::reduce
     */
    public function reduce($closure = 'add', $initializer = null);
}
