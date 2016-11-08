<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait UniqueTrait
{
    /**
     * Returns an iterator where the values from $STRATEGY are unique
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
     * @return iter\lib\UniqueIterator
     */
    public function unique($strategy = null)
    {
        return iter\unique($strategy, $this);
    }
}
