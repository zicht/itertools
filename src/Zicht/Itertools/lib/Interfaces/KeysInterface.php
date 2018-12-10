<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\KeysTrait
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
