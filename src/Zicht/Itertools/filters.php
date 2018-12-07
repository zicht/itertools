<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\filters;

use Zicht\Itertools\conversions;
use Zicht\Itertools;

/**
 * Returns a filter closure that only accepts values that are instances of $CLASS.
 *
 * For example, the following will return a list where all items
 * are instances of class Bar:
 * > $list = iterable([new Foo(), new Bar(), new Moo()]);
 * > $result = $list->filter(type(Bar::class));
 * > // {1: Bar}
 *
 * For example, the following will return a list where all items
 * have a property or array index 'key' that is an instance
 * of class Foo:
 * > $list = iterable([['key' => new Foo()], ['key => new Bar()], ['key' => new Moo()]]);
 * > $result = $list->filter(type(Bar::class, 'key'));
 * > // {1: ['key' => Bar]}
 *
 * @param string $class
 * @param null|string|\Closure $strategy
 * @return \Closure
 */
function type($class, $strategy = null)
{
    $strategy = conversions\mixed_to_value_getter($strategy);
    return function ($value, $key = null) use ($class, $strategy) {
        return $strategy($value, $key) instanceof $class;
    };
}

/**
 * Returns a filter closure that only accepts values that are in $HAYSTACK.
 *
 * For example, the following will return a list where all items
 * are either 'b' or 'c':
 * > $list = iterable(['a', 'b', 'c', 'd', 'e']);
 * > $result = $list->filter(in(['b', 'c']));
 * > // {1: 'b', 2: 'c'}
 *
 * For example, the following will return a list where all items
 * have a property or array index 'key' that is either 'b' or 'c':
 * > $list = iterable([['key' => 'a'], ['key' => 'b'], ['key' => 'c'], ['key' => 'd'], ['key' => 'e']]);
 * > $result = $list->filter(in(['b', 'c'], 'key'));
 * > // {1: ['key' => 'b'], 2: ['key' => 'c']}
 *
 * @param null|array|string|\Iterator $haystack
 * @param null|string|\Closure $strategy
 * @param boolean $strict
 * @return \Closure
 */
function in($haystack, $strategy = null, $strict = false)
{
    if (!is_bool($strict)) {
        throw new \InvalidArgumentException('$STRICT must be a boolean');
    }
    if (!is_array($haystack)) {
        $haystack = Itertools\iterable($haystack)->values();
    }
    $strategy = conversions\mixed_to_value_getter($strategy);
    return function ($value, $key = null) use ($haystack, $strategy, $strict) {
        return in_array($strategy($value, $key), $haystack, $strict);
    };
}

/**
 * Returns a filter closure that only accepts values that are not in $HAYSTACK.
 *
 * @param array|string|\Iterator $haystack
 * @param null|string|\Closure $strategy
 * @param boolean $strict
 * @return \Closure
 *
 * @deprecated Instead use not(in(...))
 */
function not_in($haystack, $strategy = null, $strict = false)
{
    if (!is_bool($strict)) {
        throw new \InvalidArgumentException('$STRICT must be a boolean');
    }
    if (!is_array($haystack)) {
        $haystack = Itertools\iterable($haystack)->values();
    }
    $strategy = conversions\mixed_to_value_getter($strategy);
    return function ($value, $key = null) use ($haystack, $strategy, $strict) {
        return !in_array($strategy($value, $key), $haystack, $strict);
    };
}

/**
 * Returns a filter closure that only accepts values that are equal to $EXPECTED
 *
 * For example, the following will return a list where all items
 * equal 'bar':
 * > $list = iterable(['foo', 'bar']);
 * > $result = $list->filter(equals('bar'));
 * > // {1: 'bar'}
 *
 * For example, the following will return a list where all items
 * have a property or array index 'foo' that equals 'bar':
 * > $list = iterable([['key' => 'foo'], ['key' => 'bar']]);
 * > $result = $list->filter(equals('bar', 'key'));
 * > // {1: ['key' => 'bar']}
 *
 * @param mixed $expected
 * @param null|string|\Closure $strategy
 * @param boolean $strict
 * @return \Closure
 */
function equals($expected, $strategy = null, $strict = false)
{
    if (!is_bool($strict)) {
        throw new \InvalidArgumentException('$STRICT must be a boolean');
    }
    $strategy = conversions\mixed_to_value_getter($strategy);
    if ($strict) {
        return function ($value, $key = null) use ($expected, $strategy) {
            return $expected === $strategy($value, $key);
        };
    } else {
        return function ($value, $key = null) use ($expected, $strategy) {
            return $expected == $strategy($value, $key);
        };
    }
}

/**
 * Returns a filter closure that inverts the value
 *
 * For example, the following will return a list where none
 * of the items equal 'bar'
 * > $list = iterable(['foo', 'bar']);
 * > $result = $list->filter(not(equals('bar')));
 * > // {0: 'foo'}
 *
 * @param null|string|\Closure $strategy
 * @return \Closure
 */
function not($strategy = null)
{
    $strategy = conversions\mixed_to_value_getter($strategy);
    return function ($value, $key = null) use ($strategy) {
        return !($strategy($value, $key));
    };
}

/**
 * Returns a filter closure that only accepts values that match the given regular expression.
 *
 * For example, the following will return a list where all items
 * match 'bar':
 * > $list = iterable(['-= foo =-', '-= bar =-']);
 * > $result = $list->filter(match('/bar/i'));
 * > // {1: '-= bar =-'}
 *
 * @param string $pattern
 * @param null|string|\Closure $strategy
 * @return \Closure
 */
function match($pattern, $strategy = null)
{
    if (!is_string($pattern)) {
        throw new \InvalidArgumentException('$PATTERN must be a string');
    }

    $strategy = conversions\mixed_to_value_getter($strategy);
    return function ($value, $key = null) use ($pattern, $strategy) {
        return (bool)preg_match($pattern, $strategy($value, $key));
    };
}
