<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\ValuesTrait
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
