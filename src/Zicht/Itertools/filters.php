<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\filters;

use Zicht\Itertools\conversions;

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
    $strategy = conversions\mixedToValueGetter($strategy);
    return function ($value) use ($class, $strategy) {
        return $strategy($value) instanceof $class;
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
 * @param array|string|\Iterator $haystack
 * @param null|string|\Closure $strategy
 * @return \Closure
 */
function in($haystack, $strategy = null)
{
    if (!is_array($haystack)) {
        $haystack = iterator_to_array(conversions\mixedToIterator($haystack));
    }
    $strategy = conversions\mixedToValueGetter($strategy);
    return function ($value) use ($haystack, $strategy) {
        return in_array($strategy($value), $haystack);
    };
}

/**
 * Returns a filter closure that only accepts values that are not in $HAYSTACK.
 *
 * @param array|string|\Iterator $haystack
 * @param null|string|\Closure $strategy
 * @return \Closure
 */
function not_in($haystack, $strategy = null)
{
    if (!is_array($haystack)) {
        $haystack = iterator_to_array(conversions\mixedToIterator($haystack));
    }
    $strategy = conversions\mixedToValueGetter($strategy);
    return function ($value) use ($haystack, $strategy) {
        return !in_array($strategy($value), $haystack);
    };
}
