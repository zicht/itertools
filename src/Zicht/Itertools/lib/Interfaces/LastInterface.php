<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface LastInterface
 *
 * @see Itertools\lib\Traits\LastTrait
 * @package Zicht\Itertools\lib\Interfaces
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
}
