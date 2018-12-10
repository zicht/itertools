<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\UniqueTrait
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
