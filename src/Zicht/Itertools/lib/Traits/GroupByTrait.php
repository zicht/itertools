<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\GroupbyIterator;

trait GroupByTrait
{
    /**
     * Make an iterator that returns consecutive groups from this
     * iterable.  Generally, this iterable needs to already be sorted on
     * the same key function.
     *
     * When $strategy is a string, the key is obtained through one of
     * the following:
     * 1. $value->{$strategy}, when $value is an object and
     *    $strategy is an existing property,
     * 2. call $value->{$strategy}(), when $value is an object and
     *    $strategy is an existing method,
     * 3. $value[$strategy], when $value is an array and $strategy
     *    is an existing key,
     * 4. otherwise the key will default to null.
     *
     * Alternatively $strategy can be a closure.  In this case the
     * $strategy closure is called with each value in this iterable and the
     * key will be its return value.  $strategy is called with two
     * parameters: the value and the key of the iterable as the first and
     * second parameter, respectively.
     *
     * The operation of groupBy() is similar to the uniq filter in Unix.
     * It generates a break or new group every time the value of the key
     * function changes (which is why it is usually necessary to have
     * sorted the data using the same key function).  That behavior
     * differs from SQL's GROUP BY which aggregates common elements
     * regardless of their input order.
     *
     * > $list = [['type'=>'A', 'title'=>'one'], ['type'=>'A', 'title'=>'two'], ['type'=>'B', 'title'=>'three']]
     * > iter\iterable($list)->groupBy('type')
     * 'A'=>[['type'=>'A', 'title'=>'one'], ['type'=>'A', 'title'=>'two']] 'B'=>[['type'=>'B', 'title'=>'three']]
     *
     * @param null|string|\Closure $strategy
     * @param bool $sort
     * @return GroupbyIterator
     */
    public function groupBy($strategy, $sort = true)
    {
        if (!is_bool($sort)) {
            throw new \InvalidArgumentException('Argument $sort must be a boolean');
        }

        if ($this instanceof \Iterator) {
            return new GroupbyIterator(
                conversions\mixed_to_value_getter($strategy),
                $sort ? $this->sorted($strategy) : $this
            );
        }

        return null;
    }
}
