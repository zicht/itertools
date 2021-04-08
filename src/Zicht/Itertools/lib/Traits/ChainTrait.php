<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.FunctionComment.ExtraParamComment

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\ChainIterator;
use Zicht\Itertools\util\Conversions;

trait ChainTrait
{
    /**
     * Returns an iterator that returns elements from the first iterable
     * until it is exhausted, then proceeds to the next iterable, until
     * all the iterables are exhausted.
     *
     * Used for creating consecutive sequences as a single sequence.
     *
     * Note that the keys of the returned ChainIterator follow 0, 1, etc,
     * regardless of the keys given in the iterables.
     *
     * > iter\iterable([1, 2, 3], [4, 5, 6])->chain()
     * 1 2 3 4 5 6
     *
     * > iter\iterable('ABC', 'DEF')->chain()
     * A B C D E F
     *
     * @param array[]|string[]|\Iterator[] ...$iterables
     * @return null|ChainIterator
     */
    public function chain(...$iterables)
    {
        if ($this instanceof \Iterator) {
            $iterables = array_map(
                fn($iterable) => Conversions::mixedToIterator($iterable),
                $iterables
            );
            return new ChainIterator($this, ...$iterables);
        }

        return null;
    }
}
