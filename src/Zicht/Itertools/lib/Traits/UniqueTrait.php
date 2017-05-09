<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\UniqueIterator;

trait UniqueTrait
{
    /**
     * Returns an iterator where the values from $strategy are unique
     *
     * The $strategy is used to get values for every element in this iterable,
     * when this value has already been encountered the element is not
     * part of the returned iterator
     *
     * > iter\iterable([1, 1, 2, 2, 3, 3])->unique()
     * 1 2 3
     *
     * > iter\iterable([['id' => 1, 'value' => 'a'], ['id' => 1, 'value' => 'b']])->unique('id')
     * ['id' => 1, 'value' => 'a']  # one element in this list
     *
     * @param null|string|\Closure $strategy
     * @return UniqueIterator
     */
    public function unique($strategy = null)
    {
        if ($this instanceof \Iterator) {
            return new UniqueIterator(
                conversions\mixed_to_value_getter($strategy),
                $this
            );
        }

        return null;
    }
}
