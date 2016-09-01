<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\mappings;

/**
 * Returns a mappings closure that strips any matching $CHARS from the left of the input string
 *
 * @param string $chars
 * @return \Closure
 */
function lstrip($chars = " \t\n\r\0\x0B")
{
    return function ($value) use ($chars) {
        return ltrim($value, $chars);
    };
}

/**
 * Returns a mapping closure that strips any matching $CHARS from the right of the input string
 *
 * @param string $chars
 * @return \Closure
 */
function rstrip($chars = " \t\n\r\0\x0B")
{
    return function ($value) use ($chars) {
        return rtrim($value, $chars);
    };
}

/**
 * Returns a mapping closure that strips any matching $CHARS from the left and right of the input string
 *
 * @param string $chars
 * @return \Closure
 */
function strip($chars = " \t\n\r\0\x0B")
{
    return function ($value) use ($chars) {
        return trim($value, $chars);
    };
}

/**
 * Returns a mapping closure returns the length of the input
 *
 * @return \Closure
 */
function length()
{
    return function ($value) {
        return sizeof($value);
    };
}

/**
 * Returns a mapping closure
 *
 * @param string $name
 * @return \Closure
 * @throws \InvalidArgumentException
 */
function get_mapping($name /* [argument, [arguments, ...] */)
{
    if (is_string($name)) {
        switch ($name) {
            case 'ltrim':
            case 'lstrip':
                return call_user_func_array('\Zicht\Itertools\mappings\lstrip', array_slice(func_get_args(), 1));

            case 'rtrim':
            case 'rstrip':
                return call_user_func_array('\Zicht\Itertools\mappings\rstrip', array_slice(func_get_args(), 1));

            case 'trim':
            case 'strip':
                return call_user_func_array('\Zicht\Itertools\mappings\strip', array_slice(func_get_args(), 1));

            case 'length':
                return call_user_func_array('\Zicht\Itertools\mappings\length', array_slice(func_get_args(), 1));
        }
    }

    throw new \InvalidArgumentException(sprintf('$NAME "%s" is not a valid mapping.', $name));
}

/**
 * @deprecated use get_mappings, will be removed in version 3.0
 */
function getMapping($name /* [argument, [arguments, ...] */)
{
    return call_user_func_array('\Zicht\Itertools\mappings\get_mapping', func_get_args());
}
