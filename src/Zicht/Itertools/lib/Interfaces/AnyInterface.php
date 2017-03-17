<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface AnyInterface
 *
 * @see Itertools\lib\Traits\AnyTrait
 * @package Zicht\Itertools\lib\Interfaces
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
