<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface UniqueInterface
 *
 * @see Itertools\lib\Traits\UniqueTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface UniqueInterface
{
    /**
     * Returns an iterator where the values from $strategy are unique
     *
     * @param null|string|\Closure $strategy
     * @return Itertools\lib\UniqueIterator
     *
     * @see Itertools\lib\Traits\UniqueTrait::unique
     */
    public function unique($strategy = null);
}
