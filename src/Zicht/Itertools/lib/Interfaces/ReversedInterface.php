<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;
use Zicht\Itertools\lib\ReversedIterator;

/**
 * @see Itertools\lib\Traits\ReversedTrait
 */
interface ReversedInterface
{
    /**
     * Returns an iterable with all the elements from this iterable reversed
     *
     * @see Itertools\lib\Traits\ReversedTrait::reversed
     */
    public function reversed(): ?ReversedIterator;
}
