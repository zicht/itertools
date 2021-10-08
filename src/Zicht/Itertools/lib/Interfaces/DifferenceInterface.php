<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools\lib\DifferenceIterator;

interface DifferenceInterface
{
    /**
     * Returns a DifferenceIterator containing elements in $this but not in $iterable
     *
     * @param array|string|\Iterator $iterable
     * @param null|string|\Closure $strategy Optional
     * @return DifferenceIterator
     */
    public function difference($iterable, $strategy = null);
}
