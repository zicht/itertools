<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\filters;

use Zicht\Itertools\conversions;
use Zicht\Itertools;

/**
 * Returns a filter closure that only accepts values that are instances of $CLASS.
 *
 * For example, the following will return a list where all items
 * are instances of class Foo:
 * > Itertools\filter(filters\type('Foo'), $list);
 *
 * For example, the following will return a list where all items
 * have a property or array index 'prop' that is an instance
 * of class Foo:
 * > Itertools\filter(filters\type('Foo', 'prop'), $list);
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
 * are either 'a' or 'b':
 * > Itertools\filter(filters\in(['a', 'b']), $list)
 *
 * For example, the following will return a list where all items
 * have a property or array index 'foo' that is either 'a' or 'b':
 * > Itertools\filter(filters\in(['a', 'b'], 'prop'), $list)
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
 * > Itertools\filter(filters\equals('bar'), $list)
 *
 * For example, the following will return a list where all items
 * have a property or array index 'foo' that equals 'bar':
 * > Itertools\filter(filters\equals('bar', 'foo'), $list)
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
