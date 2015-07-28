<?php

namespace iter;

use ArrayIterator;
use Closure;
use ReflectionClass;
use InvalidArgumentException;
use Iterator;

/**
 * Transforms anything into an Iterator or throws an InvalidArgumentException
 *
 * > mixedToIterator([1, 2, 3])
 * 1 2 3
 *
 * > mixedToIterator('foo')
 * f o o
 *
 * @param array|string|Iterator $iterable
 * @return Iterator
 */
function mixedToIterator($iterable)
{
    // an array is *not* an instance of Traversable (as it is not an
    // object and hence can not 'implement Traversable')
    if (is_array($iterable)) {
        $iterable = new ArrayIterator($iterable);
    }

    // a string is considered iterable in Python
    if (is_string($iterable)) {
        $iterable = new StringIterator($iterable);
    }

    // by now it should be an Iterator, otherwise throw an exception
    if (!($iterable instanceof Iterator)) {
        throw new InvalidArgumentException('Argument $ITERABLE must be a Traversable');
    }

    return $iterable;
}

function mixedToClosure($closure)
{
    if (is_callable($closure)) {
        $closure = function () use($closure) {
            return call_user_func_array($closure, func_get_args());
        };
    }

    if (!($closure instanceof Closure)) {
        throw new InvalidArgumentException('Argument $KEYSTRATEGY must be a Closure');
    }

    return $closure;
}

/**
 * Try to transforms something into a keyStrategy Closure.
 *
 * @param string|Closure
 * @return Closure
 */
function mixedToKeyStrategy($keyStrategy)
{
    if (is_string($keyStrategy)) {
        $keyStrategy = function ($value) use ($keyStrategy) {
            if (is_object($value) && property_exists($value, $keyStrategy)) {
                return $value->{$keyStrategy};
            }

            if (is_callable(array($value, $keyStrategy))) {
                return call_user_func(array($value, $keyStrategy));
            }

            if (is_array($value) && array_key_exists($keyStrategy, $value)) {
                return $value[$keyStrategy];
            }

            return null;
        };
    }

    return mixedToClosure($keyStrategy);
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
 * @param array|string|Iterable $iterable
 * @param string|Closure $func
 * @return AccumulateIterator
 */
function accumulate($iterable, $func = 'add')
{
    if (is_string($func)) {
        switch ($func) {
        case 'add':
            $func = function ($a, $b) {
                if (!is_numeric($a)) {
                    throw new InvalidArgumentException('Argument $A must be numeric to perform addition');
                }
                if (!is_numeric($b)) {
                    throw new InvalidArgumentException('Argument $B must be numeric to perform addition');
                }
                return $a + $b;
            };
            break;
        case 'sub':
            $func = function ($a, $b) {
                if (!is_numeric($a)) {
                    throw new InvalidArgumentException('Argument $A must be numeric to perform subtraction');
                }
                if (!is_numeric($b)) {
                    throw new InvalidArgumentException('Argument $B must be numeric to perform subtraction');
                }
                return $a - $b;
            };
            break;
        case 'mul':
            $func = function ($a, $b) {
                if (!is_numeric($a)) {
                    throw new InvalidArgumentException('Argument $A must be numeric to perform multiplication');
                }
                if (!is_numeric($b)) {
                    throw new InvalidArgumentException('Argument $B must be numeric to perform multiplication');
                }
                return $a * $b;
            };
            break;
        case 'min':
            $func = function ($a, $b) {
                if (!is_numeric($a)) {
                    throw new InvalidArgumentException('Argument $A must be numeric to determine minimum');
                }
                if (!is_numeric($b)) {
                    throw new InvalidArgumentException('Argument $B must be numeric to determine minimum');
                }
                return $a < $b ? $a : $b;
            };
            break;
        case 'max':
            $func = function ($a, $b) {
                if (!is_numeric($a)) {
                    throw new InvalidArgumentException('Argument $A must be numeric to determine maximum');
                }
                if (!is_numeric($b)) {
                    throw new InvalidArgumentException('Argument $B must be numeric to determine maximum');
                }
                return $a < $b ? $b : $a;
            };
            break;
        }
    }

    if (!($func instanceof Closure)) {
        throw new InvalidArgumentException('Argument $FUNC must be a Closure or string \'add\'');
    }

    return new AccumulateIterator(mixedToIterator($iterable), $func);
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
    $iterables = array_map(function ($iterable) { return mixedToIterator($iterable); }, func_get_args());
    $reflectorClass = new ReflectionClass('iter\ChainIterator');
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
    return new CycleIterator(mixedToIterator($iterable));
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
 * @return KeyCallbackIterator
 */
function keyCallback($keyStrategy, $iterable)
{
    return new KeyCallbackIterator(mixedToKeyStrategy($keyStrategy), mixedToIterator($iterable));
}

/**
 * Make an iterator that applies $func to every value or $iterable.
 * If additional iterables are passed, $func must take that many
 * arguments and is applied to the values from all iterables in
 * parallel.
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
 * @param Closure $func
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

    $iterables = array_map(function ($iterable) { return mixedToIterator($iterable); }, array_slice(func_get_args(), 1));
    $reflectorClass = new ReflectionClass('iter\MapIterator');
//    return $reflectorClass->newInstanceArgs(array_merge(array($func), $iterables));
    return $reflectorClass->newInstanceArgs(array_merge(array(mixedToKeyStrategy($func)), $iterables));
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
 * key will be its return value.
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
 * @return GroupbyIterator
 */
function groupby($keyStrategy, $iterable)
{
    return new GroupbyIterator(mixedToKeyStrategy($keyStrategy), mixedToIterator($iterable));
}

/**
 * Make an iterator that returns the values from $iterable sorted by
 * $keyStrategy.
 *
 * When determining the order of two entries the $keyStrategy is used
 * twice, once for each value, and the results are used to determine
 * the order.
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
 * @return SortIterator
 */
function sorted($keyStrategy, $iterable, $reverse = false)
{
    if (!is_bool($reverse)) {
        throw new InvalidArgumentException('Argument $REVERSE must be boolean');
    }
    return new SortIterator(mixedToKeyStrategy($keyStrategy), mixedToIterator($iterable), $reverse);
}

function filter($closure, $iterable)
{
    return new FilterIterator(mixedToClosure($closure), mixedToIterator($iterable));
}
