<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\AccumulateIterator;
use Zicht\Itertools\lib\ChainIterator;
use Zicht\Itertools\lib\CountIterator;
use Zicht\Itertools\lib\CycleIterator;
use Zicht\Itertools\lib\FilterIterator;
use Zicht\Itertools\lib\GroupbyIterator;
use Zicht\Itertools\lib\IterableIterator;
use Zicht\Itertools\lib\MapByIterator;
use Zicht\Itertools\lib\MapIterator;
use Zicht\Itertools\lib\RepeatIterator;
use Zicht\Itertools\lib\ReversedIterator;
use Zicht\Itertools\lib\SliceIterator;
use Zicht\Itertools\lib\SortedIterator;
use Zicht\Itertools\lib\UniqueIterator;
use Zicht\Itertools\lib\ZipIterator;
use Zicht\Itertools\reductions;

/**
 * Transforms anything into an Iterator or throws an InvalidArgumentException
 *
 * @param array|string|\Iterator $iterable
 * @return \Iterator
 *
 * @deprecated Use conversions\mixed_to_iterator instead, will be removed in version 3.0
 */
function mixedToIterator($iterable)
{
    return conversions\mixed_to_iterator($iterable);
}

/**
 * Try to transforms something into a Closure
 *
 * @param null|\Closure $closure
 * @return \Closure
 *
 * @deprecated Use conversions\mixed_to_closure instead, will be removed in version 3.0
 */
function mixedToClosure($closure)
{
    return conversions\mixed_to_closure($closure);
}

/**
 * Try to transforms something into a Closure that gets a value from $STRATEGY
 *
 * @param null|string|\Closure $strategy
 * @return \Closure
 *
 * @deprecated Use Conversions::mixedToValueGetter instead, will be removed in version 3.0
 */
function mixedToValueGetter($strategy)
{
    return conversions\mixed_to_value_getter($strategy);
}

/**
 * Try to transform something into a Closure
 *
 * @param string|\Closure $closure
 * @return \Closure
 *
 * @deprecated Will be removed in version 3.0, no replacement will be needed
 */
function mixedToOperationClosure($closure)
{
    if (is_string($closure)) {
        $closure = reductions\getReduction($closure, $closure);
    }

    if (!($closure instanceof \Closure)) {
        throw new \InvalidArgumentException('Argument $CLOSURE must be a Closure or string (i.e. "add", "join", etc)');
    }

    return $closure;
}

/**
 * Make an iterator that returns accumulated sums
 *
 * If the optional $closure argument is supplied, it should be a string:
 * add, sub, mul, min, or max.  Or it can be a Closure taking two
 * arguments that will be used to instead of addition.
 *
 * > accumulate([1,2,3,4,5])
 * 1 3 6 10 15
 *
 * > accumulate(['One', 'Two', 'Three'], function ($a, $b) { return $a . $b; })
 * 'One' 'OneTwo' 'OneTwoThree'
 *
 * @param array|string|\Iterator $iterable
 * @param string|\Closure $closure
 * @return AccumulateIterator
 */
function accumulate($iterable, $closure = 'add')
{
    return new AccumulateIterator(
        conversions\mixed_to_iterator($iterable),
        $closure instanceof \Closure ? $closure : reductions\getReduction($closure)
    );
}

/**
 * Reduce an iterator to a single value
 *
 * > reduce([1,2,3])
 * 6
 *
 * > reduce([1,2,3], 'max')
 * 3
 *
 * > reduce([1,2,3], 'sub', 10)
 * 4
 *
 * > reduce([], 'min', 1)
 * 1
 *
 * @param array|string|\Iterator $iterable
 * @param string|\Closure $closure
 * @param mixed $initializer
 * @return mixed
 */
function reduce($iterable, $closure = 'add', $initializer = null)
{
    $closure = $closure instanceof \Closure ? $closure : reductions\get_reduction($closure);
    $iterable = conversions\mixed_to_iterator($iterable);
    $iterable->rewind();

    if (null === $initializer) {
        if ($iterable->valid()) {
            $initializer = $iterable->current();
            $iterable->next();
        }
    }

    $accumulatedValue = $initializer;
    while ($iterable->valid()) {
        $accumulatedValue = $closure($accumulatedValue, $iterable->current());
        $iterable->next();
    }

    return $accumulatedValue;
}

/**
 * Make an iterator that returns elements from the first iterable
 * until it is exhausted, then proceeds to the next iterable, until
 * all the iterables are exhausted.  Used for creating consecutive
 * sequences as a single sequence
 *
 * Note that the keys of the returned ChainIterator follow 0, 1, etc,
 * regardless of the keys given in the iterables.
 *
 * > chain([1, 2, 3], [4, 5, 6])
 * 1 2 3 4 5 6
 *
 * > chain('ABC', 'DEF')
 * A B C D E F
 *
 * @param array|string|\Iterator $iterable
 * @param array|string|\Iterator $iterable2
 * @return ChainIterator
 */
function chain(/* $iterable, $iterable2, ... */)
{
    $iterables = array_map(
        function ($iterable) {
            return conversions\mixed_to_iterator($iterable);
        },
        func_get_args()
    );
    $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ChainIterator');
    return $reflectorClass->newInstanceArgs($iterables);
}

/**
 * Make an iterator that returns evenly spaced values starting with
 * number $start
 *
 * > count(10)
 * 10 11 12 13 14 ...
 *
 * > count(2.5, 0.5)
 * 2.5 3.0 3.5 4.0 ...
 *
 * @param int|float $start
 * @param int|float $step
 * @return CountIterator
 */
function count($start = 0, $step = 1)
{
    if (!(is_int($start) or is_float($start))) {
        throw new \InvalidArgumentException('Argument $START must be an integer or float');
    }

    if (!(is_int($step) or is_float($step))) {
        throw new \InvalidArgumentException('Argument $STEP must be an integer or float');
    }

    return new CountIterator($start, $step);
}

/**
 * Make an iterator returning elements from the $iterable and saving a
 * copy of each.  When the iterable is exhausted, return elements from
 * the saved copy, repeating indefinitely
 *
 * > cycle('ABCD')
 * A B C D A B C D A B C D ...
 *
 * @param array|string|\Iterator $iterable
 * @return CycleIterator
 */
function cycle($iterable)
{
    return new CycleIterator(conversions\mixed_to_iterator($iterable));
}

/**
 * Make an iterator returning values from $iterable and keys from
 * $strategy
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
 * > mapBy('id', $list)
 * 1=>['id'=>1, 'title'=>'one'] 2=>['id'=>2, 'title'=>'two']
 *
 * @param string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @return MapByIterator
 */
function mapBy($strategy, $iterable)
{
    return new MapByIterator(
        conversions\mixed_to_value_getter($strategy),
        conversions\mixed_to_iterator($iterable)
    );
}

/**
 * Make an iterator returning values from $iterable and keys from
 * $strategy
 *
 * @param string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @return MapByIterator
 *
 * @deprecated use mapBy() in stead, will be removed in version 3.0
 */
function keyCallback($strategy, $iterable)
{
    return mapBy($strategy, $iterable);
}

/**
 * Make an iterator that applies $strategy to every entry in the iterables
 *
 * If one iterable is passed, $strategy is called for each entry in
 * the $iterable, where the first argument is the value and the
 * second argument is the key of the entry
 *
 * If more than one iterable is passed, $strategy is called with the
 * values and the keys from the iterables.  For example, the first
 * call to $strategy will be:
 * $strategy($value_iterable1, $value_iterable2, $key_iterable2, $key_iterable2)
 *
 * With multiple iterables, the iterator stops when the shortest
 * iterable is exhausted.
 *
 * > $minimal = function ($value) { return min(3, $value); };
 * > map($minimal, [1, 2, 3, 4]);
 * 3 3 3 4
 *
 * > $average = function ($value1, $value2) { return ($value1 + $value2) / 2; };
 * > map($average, [1, 2, 3], [4, 5, 6]);
 * 2.5 3.5 4.5
 *
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @param array|string|\Iterator $iterable2
 * @return MapIterator
 */
function map($strategy, $iterable /*, $iterable2, ... */)
{
    $iterables = array_map(
        function ($iterable) {
            return conversions\mixed_to_iterator($iterable);
        },
        array_slice(func_get_args(), 1)
    );
    $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\MapIterator');
    return $reflectorClass->newInstanceArgs(array_merge(array(conversions\mixed_to_value_getter($strategy)), $iterables));
}

/**
 * Select values from the iterator by applying a function to each of the iterator values, i.e., mapping it to the
 * value with a strategy based on the input, similar to keyCallback
 *
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @param bool $flatten
 * @return array|MapIterator
 *
 * @deprecated Please use map(...)->values() instead (when flatten true), will be removed in version 3.0
 */
function select($strategy, $iterable, $flatten = true)
{
    if (!is_bool($flatten)) {
        throw new \InvalidArgumentException('Argument $FLATTEN must be a boolean');
    }

    $ret = new MapIterator(
        conversions\mixed_to_value_getter($strategy),
        conversions\mixed_to_iterator($iterable)
    );
    if ($flatten) {
        return $ret->values();
    }
    return $ret;
}

/**
 * Make an iterator that returns $mixed over and over again.  Runs
 * indefinitely unless the $times argument is specified
 *
 * > repeat(2)
 * 2 2 2 2 2 ...
 *
 * > repeat(10, 3)
 * 10 10 10
 *
 * @param mixed $mixed
 * @param null|int $times
 * @return RepeatIterator
 */
function repeat($mixed, $times = null)
{
    if (!(is_null($times) or (is_int($times) and $times >= 0))) {
        throw new \InvalidArgumentException('Argument $TIMES must be null or a positive integer');
    }

    return new RepeatIterator($mixed, $times);
}

/**
 * Make an iterator that returns consecutive groups from the
 * $iterable.  Generally, the $iterable needs to already be sorted on
 * the same key function
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
 * > groupby('type', $list)
 * 'A'=>[['type'=>'A', 'title'=>'one'], ['type'=>'A', 'title'=>'two']] 'B'=>[['type'=>'B', 'title'=>'three']]
 *
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @param boolean $sort
 * @return GroupbyIterator
 */
function groupBy($strategy, $iterable, $sort = true)
{
    if (!is_bool($sort)) {
        throw new \InvalidArgumentException('Argument $SORT must be a boolean');
    }

    return new GroupbyIterator(
        conversions\mixed_to_value_getter($strategy),
        $sort ? sorted($strategy, $iterable) : conversions\mixed_to_iterator($iterable)
    );
}

/**
 * Make an iterator that returns the values from $iterable sorted by
 * $strategy
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
 * > sorted('type', $list)
 * ['type'=>'A', 'title'=>'first'] ['type'=>'B', 'title'=>'second']] ['type'=>'C', 'title'=>'third']
 *
 * @param string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @param boolean $reverse
 * @return SortedIterator
 */
function sorted($strategy, $iterable, $reverse = false)
{
    if (!is_bool($reverse)) {
        throw new \InvalidArgumentException('Argument $REVERSE must be boolean');
    }
    return new SortedIterator(
        conversions\mixed_to_value_getter($strategy),
        conversions\mixed_to_iterator($iterable),
        $reverse
    );
}

/**
 * Make an iterator that returns values from $iterable where the
 * $strategy determines that the values are not empty
 *
 * @param null|string|\Closure $strategy, Optional, when not specified !empty will be used
 * @param array|string|\Iterator $iterable
 * @return FilterIterator
 */
function filter(/* [$strategy, ] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $strategy = null;
            $iterable = $args[0];
            break;

        case 2:
            $strategy = $args[0];
            $iterable = $args[1];
            break;

        default:
            throw new \InvalidArgumentException('filter requires either one (iterable) or two (strategy, iterable) arguments');
    }

    $strategy = conversions\mixed_to_value_getter($strategy);
    $isValid = function ($value, $key) use ($strategy) {
        $tempVarPhp54 = $strategy($value, $key);
        return !empty($tempVarPhp54);
    };

    return new FilterIterator($isValid, conversions\mixed_to_iterator($iterable));
}

/**
 * TODO: document!
 * TODO: unit tests!
 *
 * @param string|\Closure $strategy
 * @param \Closure $closure Optional, when not specified !empty will be used
 * @param array|string|\Iterator $iterable
 * @return FilterIterator
 *
 * @deprecated Use filter() instead, will be removed in version 3.0
 */
function filterBy(/* $strategy, [$closure, ] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 2:
            $strategy = conversions\mixed_to_value_getter($args[0]);
            $closure = function ($value, $key) use ($strategy) {
                $tempVarPhp54 = call_user_func($strategy, $value, $key);
                return !empty($tempVarPhp54);
            };
            $iterable = conversions\mixed_to_iterator($args[1]);
            break;

        case 3:
            $strategy = conversions\mixed_to_value_getter($args[0]);
            $userClosure = $args[1];
            $closure = function ($value, $key) use ($strategy, $userClosure) {
                return call_user_func($userClosure, call_user_func($strategy, $value, $key));
            };
            $iterable = conversions\mixed_to_iterator($args[2]);
            break;

        default:
            throw new \InvalidArgumentException('filterBy requires either two (strategy, iterable) or three (strategy, closure, iterable) arguments');
    }

    return new FilterIterator($closure, $iterable);
}

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
 * @param array|string|\Iterator $iterable
 * @param array|string|\Iterator $iterable2
 * @return ZipIterator
 */
function zip(/* $iterable, $iterable2, ... */)
{
    $iterables = array_map(
        function ($iterable) {
            return conversions\mixed_to_iterator($iterable);
        },
        func_get_args()
    );
    $reflectorClass = new \ReflectionClass('\Zicht\Itertools\lib\ZipIterator');
    return $reflectorClass->newInstanceArgs($iterables);
}

/**
 * Returns an iterable with all the elements from $ITERABLE reversed
 *
 * @param array|string|\Iterator $iterable
 * @return ReversedIterator
 */
function reversed($iterable)
{
    return new ReversedIterator(conversions\mixed_to_iterator($iterable));
}

/**
 * Returns an iterator where the values from $STRATEGY are unique
 *
 * The $strategy is used to get values for every element in $iterable,
 * when this value has already been encountered the element is not
 * part of the returned iterator
 *
 * > unique([1, 1, 2, 2, 3, 3])
 * 1 2 3
 *
 * > unique('id', [['id' => 1, 'value' => 'a'], ['id' => 1, 'value' => 'b']])
 * ['id' => 1, 'value' => 'a']  # one element in this list
 *
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @return UniqueIterator
 */
function unique(/* [$strategy,] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $strategy = null;
            $iterable = $args[0];
            break;

        case 2:
            $strategy = $args[0];
            $iterable = $args[1];
            break;

        default:
            throw new \InvalidArgumentException('unique requires either one (iterable) or two (strategy, iterable) arguments');
    }

    return new UniqueIterator(
        conversions\mixed_to_value_getter($strategy),
        conversions\mixed_to_iterator($iterable)
    );
}

/**
 * TODO: document!
 *
 * @deprecated use unique($strategy, $iterable) instead, will be removed in version 3.0
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @return UniqueIterator
 */
function uniqueBy($strategy, $iterable)
{
    return new UniqueIterator(
        conversions\mixed_to_value_getter($strategy),
        conversions\mixed_to_iterator($iterable)
    );
}

/**
 * Returns true when one or more element of $ITERABLE is not empty, otherwise returns false
 *
 * When the optional $STRATEGY argument is given, this argument is used to obtain the
 * value which is tested to be empty.
 *
 * > any([0, '', false])
 * false
 *
 * > any([1, null, 3])
 * true
 *
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @return boolean
 */
function any(/* [$strategy,] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $strategy = conversions\mixed_to_value_getter(null);
            $iterable = conversions\mixed_to_iterator($args[0]);
            break;

        case 2:
            $strategy = conversions\mixed_to_value_getter($args[0]);
            $iterable = conversions\mixed_to_iterator($args[1]);
            break;

        default:
            throw new \InvalidArgumentException('any requires either one (iterable) or two (strategy, iterable) arguments');
    }

    foreach ($iterable as $item) {
        $tempVarPhp54 = call_user_func($strategy, $item);
        if (!empty($tempVarPhp54)) {
            return true;
        }
    }

    return false;
}

/**
 * Returns true when all elements of $ITERABLE are not empty, otherwise returns false
 *
 * When the optional $STRATEGY argument is given, this argument is used to obtain the
 * value which is tested to be empty.
 *
 * > all([1, 'hello world', true])
 * true
 *
 * > all([1, null, 3])
 * false
 *
 * @param null|string|\Closure $strategy
 * @param array|string|\Iterator $iterable
 * @return boolean
 */
function all(/* [$strategy,] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $strategy = conversions\mixed_to_value_getter(null);
            $iterable = conversions\mixed_to_iterator($args[0]);
            break;

        case 2:
            $strategy = conversions\mixed_to_value_getter($args[0]);
            $iterable = conversions\mixed_to_iterator($args[1]);
            break;

        default:
            throw new \InvalidArgumentException('all requires either one (iterable) or two (strategy, iterable) arguments');
    }

    foreach ($iterable as $item) {
        $tempVarPhp54 = call_user_func($strategy, $item);
        if (empty($tempVarPhp54)) {
            return false;
        }
    }

    return true;
}

/**
 * TODO: document!
 *
 * @param array|string|\Iterator $iterable
 * @param integer $start
 * @param null|integer $end
 * @return SliceIterator
 */
function slice($iterable, $start, $end = null)
{
    if (!is_int($start)) {
        throw new \InvalidArgumentException('Argument $START must be an integer');
    }
    if (!(is_null($end) || is_int($end))) {
        throw new \InvalidArgumentException('Argument $END must be an integer or null');
    }
    return new SliceIterator(conversions\mixed_to_iterator($iterable), $start, $end);
}

/**
 * Returns the first element of $ITERABLE or returns $DEFAULT when $ITERABLE is empty
 *
 * TODO: unit tests!
 *
 * @param array|string|\Iterator $iterable
 * @param mixed $default
 * @return mixed
 */
function first($iterable, $default = null)
{
    $item = $default;
    foreach (conversions\mixed_to_iterator($iterable) as $item) {
        break;
    }
    return $item;
}

/**
 * Returns the last element of $ITERABLE or returns $DEFAULT when $ITERABLE is empty
 *
 * TODO: unit tests!
 *
 * @param array|string|\Iterator $iterable
 * @param mixed $default
 * @return mixed
 */
function last($iterable, $default = null)
{
    $item = $default;
    foreach (conversions\mixed_to_iterator($iterable) as $item) {
    }
    return $item;
}

/**
 * TODO: document!
 * TODO: unit tests!
 *
 * @param array|string|\Iterator $iterable
 * @return IterableIterator
 */
function iterable($iterable)
{
    return new IterableIterator(conversions\mixed_to_iterator($iterable));
}
