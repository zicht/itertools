<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface FirstInterface
 *
 * @see Itertools\lib\Traits\FirstTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface FirstInterface
{
    /**
     * Returns the first element of this iterable or
     * returns $default when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     *
     * @see Itertools\lib\Traits\FirstTrait::first
     */
    public function first($default = null);
}
