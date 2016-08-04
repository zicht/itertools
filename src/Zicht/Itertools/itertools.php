<?php

namespace Zicht\Itertools;

use Closure;
use Zicht\Itertools\lib\AccumulateIterator;
use Zicht\Itertools\lib\ChainIterator;
use Zicht\Itertools\lib\CountIterator;
use Zicht\Itertools\lib\CycleIterator;
use Zicht\Itertools\lib\FilterIterator;
use Zicht\Itertools\lib\GroupbyIterator;
use Zicht\Itertools\lib\MapByIterator;
use Zicht\Itertools\lib\MapIterator;
use Zicht\Itertools\lib\RepeatIterator;
use Zicht\Itertools\lib\ReversedIterator;
use Zicht\Itertools\lib\SliceIterator;
use Zicht\Itertools\lib\SortedIterator;
use ReflectionClass;
use InvalidArgumentException;
use Iterator;
use Zicht\Itertools\lib\UniqueIterator;
use Zicht\Itertools\lib\ZipIterator;
use Zicht\Itertools\util\Conversions;
use Zicht\Itertools\util\Reductions;

/**
 * @deprecated Use Conversions::mixedToIterator instead
 * @param array|string|Iterator $iterable
 * @return Iterator
 */
function mixedToIterator($iterable)
{
    return Conversions::mixedToIterator($iterable);
}

/**
 * @deprecated Use Conversions::mixedToClosure instead
 * @param $closure
 * @return Closure
 */
function mixedToClosure($closure)
{
    return Conversions::mixedToClosure($closure);
}

/**
 * @deprecated Use Conversions::mixedToValueGetter instead
 * @param null|string|Closure
 * @return Closure
 */
function mixedToValueGetter($strategy)
{
    return Conversions::mixedToValueGetter($strategy);
}

/**
 * Try to transform something into a Closure.
 *
 * @param string|$closure
 * @return Closure
 */
function mixedToOperationClosure($closure)
{
    if (is_string($closure)) {
        $closure = Reductions::getReduction($closure, $closure);
    }

    if (!($closure instanceof Closure)) {
        throw new InvalidArgumentException('Argument $CLOSURE must be a Closure or string (i.e. "add", "join", etc)');
    }

    return $closure;
}

/**
 * Make an iterator that returns accumulated sums.
 *
 * If the optional $func argument is supplied, it should be a string:
 * add, sub, mul, min, or max.  Or it can be a Closure taking two
 * arguments that will be used to instead of addition.
 *
 * > accumulate([1,2,3,4,5])
 * 1 3 6 10 15
 *
 * > accumulate(['one', 'two', 'three'], function ($a, $b) { return $a . $b; })
 * 'one' 'onetwo' 'onetwothree'
 *
 * @param array|string|Iterator $iterable
 * @param string|Closure $closure
 * @return AccumulateIterator
 */
function accumulate($iterable, $closure = 'add')
{
    return new AccumulateIterator(Conversions::mixedToIterator($iterable), mixedToOperationClosure($closure));
}

/**
 * Reduce an iterator to a single value.
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
 * @param array|string|Iterator $iterable
 * @param string|Closure $closure
 * @param mixed $initializer
 * @return mixed
 */
function reduce($iterable, $closure = 'add', $initializer = null)
{
    if (null !== $initializer) {
        $iterable = chain([$initializer], $iterable);
    }

    $value = $initializer;
    foreach (accumulate($iterable, $closure) as $value) {};
    return $value;
}

/**
 * Make an iterator that returns elements from the first iterable
 * until it is exhausted, then prodeeds to the next iterable, until
 * all the iterables are exhausted.  Used for creating consecutive
 * sequences as a single sequence.
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
 * @param array|string|Iterator $iterable1
 * @param array|string|Iterator $iterable2
 * @param array|string|Iterator $iterableN
 * @return ChainIterator
 */
function chain(/* $iterable1, $iterable2, ... */)
{
    $iterables = array_map(function ($iterable) { return Conversions::mixedToIterator($iterable); }, func_get_args());
    $reflectorClass = new ReflectionClass('\Zicht\Itertools\lib\ChainIterator');
    return $reflectorClass->newInstanceArgs($iterables);
}

/**
 * Make an iterator that returns eventy spaced values starting with
 * number $start.
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
        throw new InvalidArgumentException('Argument $START must be an integer or float');
    }

    if (!(is_int($step) or is_float($step))) {
        throw new InvalidArgumentException('Argument $STEP must be an integer or float');
    }

    return new CountIterator($start, $step);
}

/**
 * Make an iterator returning elements from the $iterable and saving a
 * copy of each.  When the iterable is exhausted, return elements from
 * the saved copy.  Repeats indefinately.
 *
 * > cycle('ABCD')
 * A B C D A B C D A B C D ...
 *
 * @param array|string|Iterator $iterable
 * @return CycleIterator
 */
function cycle($iterable)
{
    return new CycleIterator(Conversions::mixedToIterator($iterable));
}

/**
 * Make an iterator returning values from $iterable and keys from
 * $keyStrategy.
 *
 * When $keyStrategy is a string, the key is obtained through one of
 * the following:
 * 1. $value->{$keyStrategy}, when $value is an object and
 *    $keyStrategy is an existing property,
 * 2. call $value->{$keyStrategy}(), when $value is an object and
 *    $keyStrategy is an existing method,
 * 3. $value[$keyStrategy], when $value is an array and $keyStrategy
 *    is an existing key,
 * 4. otherwise the key will default to null.
 *
 * Alternatively $keyStrategy can be a closure.  In this case the
 * $keyStrategy closure is called with each value in $iterable and the
 * key will be its return value.
 *
 * > $list = [['id'=>1, 'title'=>'one'], ['id'=>2, 'title'=>'two']]
 * > keyCallback('id', $list)
 * 1=>['id'=>1, 'title'=>'one'] 2=>['id'=>2, 'title'=>'two']
 *
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @return MapByIterator
 */
function mapBy($keyStrategy, $iterable)
{
    return new MapByIterator(Conversions::mixedToValueGetter($keyStrategy), Conversions::mixedToIterator($iterable));
}

/**
 * @deprecated use mapBy() in stead
 */
function keyCallback($keyStrategy, $iterable)
{
    return mapBy($keyStrategy, $iterable);
}

/**
 * Make an iterator that applies $func to every entry in the $iterables.
 *
 * If one iterable is passed, $func is called for each entry in
 * the $iterable, where the first argument is the value and the
 * second argument is the key of the entry.
 *
 * If more than one iterable is passed, $func is called with the
 * values and the keys from the iterables.  For example, the first
 * call to $func will be:
 * $func($value_iterable1, $value_iterable2, $key_iterable2, $key_iterable2)
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
 * @param Closure|callable $func
 * @param array|string|Iterator $iterable1
 * @param array|string|Iterator $iterable2
 * @param array|string|Iterator $iterableN
 * @return MapIterator
 */
function map($func /* $iterable1, $iterable2, ... */)
{
//    if (!($func instanceof Closure)) {
//        throw new InvalidArgumentException('Argument $FUNC must be a Closure');
//    }

    $iterables = array_map(function ($iterable) { return Conversions::mixedToIterator($iterable); }, array_slice(func_get_args(), 1));
    $reflectorClass = new ReflectionClass('\Zicht\Itertools\lib\MapIterator');
//    return $reflectorClass->newInstanceArgs(array_merge(array($func), $iterables));
    return $reflectorClass->newInstanceArgs(array_merge(array(Conversions::mixedToValueGetter($func)), $iterables));
}


/**
 * Select values from the iterator by applying a function to each of the iterator values, i.e., mapping it to the
 * value with a strategy based on the input, similar to keyCallback
 *
 * @param mixed $valueStrategy
 * @param mixed $iterable
 * @param bool $flatten
 * @return MapIterator
 */
function select($valueStrategy, $iterable, $flatten = true)
{
    $ret = new MapIterator(Conversions::mixedToValueGetter($valueStrategy), Conversions::mixedToIterator($iterable));
    if ($flatten) {
        return array_values(iterator_to_array($ret));
    }
    return $ret;
}


/**
 * Make an iterator that returns $mixed over and over again.  Runs
 * indefinately unless the $times argument is specified.
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
        throw new InvalidArgumentException('Argument $TIMES must be null or a positive integer');
    }

    return new RepeatIterator($mixed, $times);
}
/**
 * Make an iterator that returns consecutive groups from the
 * $iterable.  Generally, the $iterable needs to already be sorted on
 * the same key function.
 *
 * When $keyStrategy is a string, the key is obtained through one of
 * the following:
 * 1. $value->{$keyStrategy}, when $value is an object and
 *    $keyStrategy is an existing property,
 * 2. call $value->{$keyStrategy}(), when $value is an object and
 *    $keyStrategy is an existing method,
 * 3. $value[$keyStrategy], when $value is an array and $keyStrategy
 *    is an existing key,
 * 4. otherwise the key will default to null.
 *
 * Alternatively $keyStrategy can be a closure.  In this case the
 * $keyStrategy closure is called with each value in $iterable and the
 * key will be its return value.  $keyStrategy is called with two
 * parameters: the value and the key of the iterable as the first and
 * second parameter, respectively.
 *
 * The operation of groupby() is similar to the uniq filter in Unix.
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
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @param boolean $sort
 * @return GroupbyIterator
 */
function groupby($keyStrategy, $iterable, $sort = true)
{
    if (!is_bool($sort)) {
        throw new InvalidArgumentException('Argument $SORT must be a boolean');
    }

    return new GroupbyIterator(
        Conversions::mixedToValueGetter($keyStrategy),
        $sort ? sorted($keyStrategy, $iterable) : Conversions::mixedToIterator($iterable));
}

/**
 * Make an iterator that returns the values from $iterable sorted by
 * $keyStrategy.
 *
 * When determining the order of two entries the $keyStrategy is called
 * twice, once for each value, and the results are used to determine
 * the order.  $keyStrategy is called with two parameters: the value and
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
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @param boolean $reverse
 * @return SortedIterator
 */
function sorted($keyStrategy, $iterable, $reverse = false)
{
    if (!is_bool($reverse)) {
        throw new InvalidArgumentException('Argument $REVERSE must be boolean');
    }
    return new SortedIterator(Conversions::mixedToValueGetter($keyStrategy), Conversions::mixedToIterator($iterable), $reverse);
}

/**
 * TODO: document!
 * TODO: I am not happy about the API... filter should become filter([$keyStrategy], $iterable)
 * TODO: and the $closure argument should be removed (and its behavior become implicit)
 * TODO: this allows us to remove the filterBy function
 *
 * @param Closure $closure Optional, when not specified !empty will be used
 * @param array|string|Iterator $iterable
 * @return FilterIterator
 */
function filter(/* [$closure, ] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $closure = function ($item) { return !empty($item); };
            $iterable = Conversions::mixedToIterator($args[0]);
            break;

        case 2:
            $closure = Conversions::mixedToValueGetter($args[0]);
            $iterable = Conversions::mixedToIterator($args[1]);
            break;

        default:
            throw new InvalidArgumentException('filter requires either one (iterable) or two (closure, iterable) arguments');
    }

    return new FilterIterator($closure, $iterable);
}

/**
 * TODO: document!
 * TODO: unit tests!
 *
 * @param string|Closure $keyStrategy
 * @param Closure $closure Optional, when not specified !empty will be used
 * @param array|string|Iterator $iterable
 * @return FilterIterator
 */
function filterBy(/* $keyStrategy, [$closure, ] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 2:
            $keyStrategy = Conversions::mixedToValueGetter($args[0]);
            $closure = function ($item) use ($keyStrategy) { $tempVarPhp54 = call_user_func($keyStrategy, $item); return !empty($tempVarPhp54); };
            $iterable = Conversions::mixedToIterator($args[1]);
            break;

        case 3:
            $keyStrategy = Conversions::mixedToValueGetter($args[0]);
            $userClosure = $args[1];
            $closure = function ($item) use ($keyStrategy, $userClosure) { return call_user_func($userClosure, call_user_func($keyStrategy, $item)); };
            $iterable = Conversions::mixedToIterator($args[2]);
            break;

        default:
            throw new InvalidArgumentException('filterBy requires either two (keyStrategy, iterable) or three (keyStrategy, closure, iterable) arguments');
    }

    return new FilterIterator($closure, $iterable);
}

/**
 * TODO: document!
 *
 * @param array|string|Iterator $iterable1
 * @param array|string|Iterator $iterable2
 * @param array|string|Iterator $iterableN
 * @return ZipIterator
 */
function zip(/* $iterable1, $iterable2, ... */)
{
    $iterables = array_map(function ($iterable) { return Conversions::mixedToIterator($iterable); }, func_get_args());
    $reflectorClass = new ReflectionClass('\Zicht\Itertools\lib\ZipIterator');
    return $reflectorClass->newInstanceArgs($iterables);
}

/**
 * TODO: document!
 *
 * @param array|string|Iterator $iterable
 * @return ReversedIterator
 */
function reversed($iterable)
{
    return new ReversedIterator(Conversions::mixedToIterator($iterable));
}

/**
 * TODO: document!
 *
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @return UniqueIterator
 */
function unique(/* $keyStrategy, $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $keyStrategy = function ($value) { return $value; };
            $iterable = Conversions::mixedToIterator($args[0]);
            break;

        case 2:
            $keyStrategy = Conversions::mixedToValueGetter($args[0]);
            $iterable = Conversions::mixedToIterator($args[1]);
            break;

        default:
            throw new InvalidArgumentException('unique requires either one (iterable) or two (keyStrategy, iterable) arguments');
    }
    return new UniqueIterator($keyStrategy, $iterable);
}

/**
 * TODO: document!
 *
 * @deprecated use unique($keyStrategy, $iterable) instead
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @return UniqueIterator
 */
function uniqueBy($keyStrategy, $iterable)
{
    return new UniqueIterator(Conversions::mixedToValueGetter($keyStrategy), Conversions::mixedToIterator($iterable));
}

/**
 * TODO: document!
 *
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @return boolean
 */
function any(/* [$keyStrategy, ] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $keyStrategy = function ($item) {
                return $item;
            };
            $iterable = Conversions::mixedToIterator($args[0]);
            break;

        case 2:
            $keyStrategy = Conversions::mixedToValueGetter($args[0]);
            $iterable = Conversions::mixedToIterator($args[1]);
            break;

        default:
            throw new InvalidArgumentException('filter requires either one (iterable) or two (keyStrategy, iterable) arguments');
    }

    foreach ($iterable as $item) {
        if (!empty(call_user_func($keyStrategy, $item))) {
            return true;
        }
    }

    return false;
}

/**
 * TODO: document!
 *
 * @param string|Closure $keyStrategy
 * @param array|string|Iterator $iterable
 * @return boolean
 */
function all(/* [$keyStrategy, ] $iterable */)
{
    $args = func_get_args();
    switch (sizeof($args)) {
        case 1:
            $keyStrategy = function ($item) {
                return $item;
            };
            $iterable = Conversions::mixedToIterator($args[0]);
            break;

        case 2:
            $keyStrategy = Conversions::mixedToValueGetter($args[0]);
            $iterable = Conversions::mixedToIterator($args[1]);
            break;

        default:
            throw new InvalidArgumentException('filter requires either one (iterable) or two (keyStrategy, iterable) arguments');
    }

    foreach ($iterable as $item) {
        if (empty(call_user_func($keyStrategy, $item))) {
            return false;
        }
    }

    return true;
}

/**
 * TODO: document!
 * TODO: unit tests!
 *
 * @param array|string|Iterator $iterable
 * @param integer $start
 * @param null|integer $end
 * @return SliceIterator
 */
function slice($iterable, $start, $end = null)
{
    if (!is_int($start)) {
        throw new InvalidArgumentException('Argument $START must be an integer');
    }
    if (!(is_null($end) || is_int($end))) {
        throw new InvalidArgumentException('Argument $END must be an integer or null');
    }
    return new SliceIterator(Conversions::mixedToIterator($iterable), $start, $end);
}

/**
 * TODO: document!
 * TODO: unit tests!
 *
 * @param array|string|Iterator $iterable
 * @param mixed $default
 * @return mixed
 */
function first($iterable, $default = null)
{
    $item = $default;
    foreach (Conversions::mixedToIterator($iterable) as $item) {
        break;
    }
    return $item;
}

/**
 * TODO: document!
 * TODO: unit tests!
 *
 * @param array|string|Iterator $iterable
 * @param mixed $default
 * @return mixed
 */
function last($iterable, $default = null)
{
    $item = $default;
    foreach (Conversions::mixedToIterator($iterable) as $item) {}
    return $item;
}
