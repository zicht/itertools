<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.FunctionComment.ExtraParamComment

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\ZipIterator;
use Zicht\Itertools\util\Conversions;

trait ZipTrait
{
    /**
     * Returns an iterator where one or more iterables are zipped together
     *
     * This function returns a list of tuples, where the i-th tuple contains
     * the i-th element from each of the argument sequences or iterables.
     *
     * The returned list is truncated in length to the length of the
     * shortest argument sequence.
     *
     * > zip([1, 2, 3], ['a', 'b', 'c'])
     * [1, 'a'] [2, 'b'] [3, 'c']
     *
     * @param array[]|string[]|\Iterator[] ...$iterables
     * @return ZipIterator
     */
    public function zip(...$iterables)
    {
        if ($this instanceof \Iterator) {
            $iterables = array_map(
                function ($iterable) {
                    return Conversions::mixedToIterator($iterable);
                },
                $iterables
            );
            $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ZipIterator');
            return $reflectorClass->newInstanceArgs(array_merge([$this], $iterables));
        }

        return null;
    }
}
