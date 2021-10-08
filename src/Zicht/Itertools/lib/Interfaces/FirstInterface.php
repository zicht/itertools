<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\FirstTrait
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

    /**
     * Returns the key of the first element of this iterable or
     * returns $DEFAULT when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function firstKey($default = null);
}
