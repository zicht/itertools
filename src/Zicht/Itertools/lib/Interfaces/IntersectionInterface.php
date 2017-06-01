<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools\lib\IntersectionIterator;

/**
 * Interface IntersectionInterface
 *
 * @package Zicht\Itertools\lib\Interfaces
 */
interface IntersectionInterface
{
    /**
     * Returns an IntersectionIterator containing elements in $this that are also in $iterable
     *
     * @param array|string|\Iterator $iterable
     * @param null|string|\Closure $strategy Optional
     * @return IntersectionIterator
     */
    public function intersection($iterable, $strategy = null);
}
