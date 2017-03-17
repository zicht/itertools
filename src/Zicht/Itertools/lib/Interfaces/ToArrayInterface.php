<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface ToArrayInterface
 *
 * @see Itertools\lib\Traits\ToArrayTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface ToArrayInterface
{
    /**
     * Returns an unsafe array build from this iterator
     *
     * @return array
     *
     * @see Itertools\lib\Traits\ToArrayTrait::toArray
     */
    public function toArray();
}
