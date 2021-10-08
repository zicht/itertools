<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\LastTrait
 */
interface LastInterface
{
    /**
     * Returns the last element of this iterable or
     * returns $default when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function last($default = null);

    /**
     * Returns the key of the last element of this iterable or
     * returns $DEFAULT when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function lastKey($default = null);
}
