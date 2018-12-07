<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\MapByIterator;

trait MapByTrait
{
    /**
     * Make an iterator returning values from  this iterable and keys
     * from $strategy.
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
     * $strategy closure is called with each value in $iterable and the
     * key will be its return value.
     *
     * > $list = [['id'=>1, 'title'=>'one'], ['id'=>2, 'title'=>'two']]
     * > iter\iterable($list)->mapBy('id')
     * 1=>['id'=>1, 'title'=>'one'] 2=>['id'=>2, 'title'=>'two']
     *
     * @param null|string|\Closure $strategy
     * @return MapByIterator
     */
    public function mapBy($strategy)
    {
        if ($this instanceof \Iterator) {
            return new MapByIterator(
                conversions\mixed_to_value_getter($strategy),
                $this
            );
        }

        return null;
    }
}
