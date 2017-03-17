<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface ReversedInterface
 *
 * @see Itertools\lib\Traits\ReversedTrait
 * @package Zicht\Itertools\lib\Interfaces
 */
interface ReversedInterface
{
    /**
     * Returns an iterable with all the elements from this iterable reversed
     *
     * @return Itertools\lib\ReversedIterator
     *
     * @see Itertools\lib\Traits\ReversedTrait::reversed
     */
    public function reversed();
}
