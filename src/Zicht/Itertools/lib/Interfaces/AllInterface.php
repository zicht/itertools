<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\AllTrait
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
