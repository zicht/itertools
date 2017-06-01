<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools\lib\DifferenceIterator;

/**
 * Interface IntersectionInterface
 *
 * @package Zicht\Itertools\lib\Interfaces
 */
interface IntersectionInterface
{
    /**
     * Returns a DifferenceIterator containing elements in $this but not in $iterable
     *
     * @param array|string|\Iterator $iterable
     * @param null|string|\Closure $strategy Optional, when not specified !empty will be used
     * @return IntersectionIterator
     */
    public function intersection($iterable, $strategy = null);
}
