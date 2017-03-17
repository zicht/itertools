<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface AllInterface
 *
 * @see Itertools\lib\Traits\AllTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface AllInterface
{
    /**
     * Returns true when all elements of this iterable are not empty, otherwise returns false
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return bool
     *
     * @see Itertools\lib\Traits\AllTrait::all
     */
    public function all($strategy = null);
}
