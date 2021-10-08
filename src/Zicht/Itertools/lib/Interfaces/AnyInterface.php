<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\AnyTrait
 */
interface AnyInterface
{
    /**
     * Returns true when one or more element of this iterable is not empty, otherwise returns false
     *
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return bool
     *
     * @see Itertools\lib\Traits\AnyTrait::any
     */
    public function any($strategy = null);
}
