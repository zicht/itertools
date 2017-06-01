<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools\lib\DifferenceIterator;

/**
 * Interface DifferenceInterface
 *
 * @package Zicht\Itertools\lib\Interfaces
 */
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
