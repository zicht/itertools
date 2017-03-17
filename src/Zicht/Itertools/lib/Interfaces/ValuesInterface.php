<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface ValuesInterface
 *
 * @see Itertools\lib\Traits\ValuesTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface ValuesInterface
{
    /**
     * Returns an array with values from this iterator
     *
     * @return array
     *
     * @see Itertools\lib\Traits\ValuesTrait::values
     */
    public function values();
}
