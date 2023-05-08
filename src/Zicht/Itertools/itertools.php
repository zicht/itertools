<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools;

use Doctrine\Common\Collections\Collection;
use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\IterableIterator;
use Zicht\Itertools\util\Conversions;

/**
 * Returns an FiniteIterableInterface, providing a fluent interface to itertools
 *
 * > iterable([1, 2, 3])->filter(...)->map(...)->first(...)
 *
 * @param array|string|Collection|\Iterator|iterable $iterable
 * @return FiniteIterableInterface
 */
function iterable($iterable = null)
{
    if ($iterable instanceof FiniteIterableInterface) {
        return $iterable;
    }

    return new IterableIterator(Conversions::mixedToIterator($iterable));
}
