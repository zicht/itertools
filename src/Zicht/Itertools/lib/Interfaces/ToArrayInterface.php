<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\ToArrayTrait
 */
interface ToArrayInterface
{
    /**
     * Returns an unsafe array build from this iterator
     *
     * @see Itertools\lib\Traits\ToArrayTrait::toArray
     */
    public function toArray(): array;
}
