<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

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
     * @param array|string|\Iterator $iterable2
     * @return iter\lib\ZipIterator
     */
    public function zip(/* $iterable2, ... */)
    {
        if ($this instanceof \Iterator) {
            $iterables = array_map(
                '\Zicht\Itertools\conversions\mixed_to_iterator',
                func_get_args()
            );
            $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ZipIterator');
            return $reflectorClass->newInstanceArgs(array_merge([$this], $iterables));
        }

        return null;
    }
}
