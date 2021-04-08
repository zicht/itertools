<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\SortedIterator;
use Zicht\Itertools\util\Conversions;

trait SortedTrait
{
    /**
     * Make an iterator that returns the values from this iterable
     * sorted by $strategy
     *
     * When determining the order of two entries the $strategy is called
     * twice, once for each value, and the results are used to determine
     * the order.  $strategy is called with two parameters: the value and
     * the key of the iterable as the first and second parameter, respectively.
     *
     * When $reverse is true the order of the results are reversed.
     *
     * The sorted() function is guaranteed to be stable.  A sort is stable
     * if it guarantees not to change the relative order of elements that
     * compare equal.  this is helpful for sorting in multiple passes (for
     * example, sort by department, then by salary grade).  This also
     * holds up when $reverse is true.
     *
     * > $list = [['type'=>'B', 'title'=>'second'], ['type'=>'C', 'title'=>'third'], ['type'=>'A', 'title'=>'first']]
     * > iter\iterable($list)->sorted('type')
     * ['type'=>'A', 'title'=>'first'] ['type'=>'B', 'title'=>'second']] ['type'=>'C', 'title'=>'third']
     *
     * @param null|string|\Closure $strategy
     * @param bool $reverse
     * @return SortedIterator
     */
    public function sorted($strategy = null, bool $reverse = false)
    {
        if ($this instanceof \Iterator) {
            return new SortedIterator(
                Conversions::mixedToValueGetter($strategy),
                $this,
                $reverse
            );
        }

        return null;
    }
}
