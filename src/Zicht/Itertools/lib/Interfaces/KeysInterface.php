<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface KeysInterface
 *
 * @see Itertools\lib\Traits\KeysTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface KeysInterface
{
    /**
     * Returns an array with keys from this iterator
     *
     * @return array
     *
     * @see Itertools\lib\Traits\KeysTrait::keys
     */
    public function keys();
}
