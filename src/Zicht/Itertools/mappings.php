<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\mappings;

use Zicht\Itertools\util\Mappings;

/**
 * Returns a closure that strips any matching $CHARS from the left of the input string
 *
 * @param string $chars
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::lstrip($chars), will be removed in version 3.0
 */
function lstrip($chars = " \t\n\r\0\x0B")
{
    return Mappings::lstrip($chars);
}

/**
 * Returns a closure that strips any matching $CHARS from the right of the input string
 *
 * @param string $chars
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::lstrip($chars), will be removed in version 3.0
 */
function rstrip($chars = " \t\n\r\0\x0B")
{
    return Mappings::rstrip($chars);
}

/**
 * Returns a closure that strips any matching $CHARS from the left and right of the input string
 *
 * @param string $chars
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::strip($chars), will be removed in version 3.0
 */
function strip($chars = " \t\n\r\0\x0B")
{
    return Mappings::strip($chars);
}

/**
 * Returns a closure that returns the length of the input
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::length(), will be removed in version 3.0
 */
function length()
{
    return Mappings::length();
}

/**
 * Returns a closure that returns the key
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::key(), will be removed in version 3.0
 */
function key()
{
    return Mappings::key();
}

/**
 * Returns a closure that returns the string value lower cased
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::lower(), will be removed in version 3.0
 */
function lower()
{
    return Mappings::lower();
}

/**
 * Returns a closure that returns the string value upper cased
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::upper(), will be removed in version 3.0
 */
function upper()
{
    return Mappings::upper();
}

/**
 * Returns a closure that returns the value cast to a string
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::string(), will be removed in version 3.0
 */
function string()
{
    return Mappings::string();
}

/**
 * Returns a closure that returns the value as a json_encoded string
 *
 * @param int $options
 * @param int $depth
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::jsonEncode($options, $depth), will be removed in version 3.0
 */
function json_encode($options = 0, $depth = 512)
{
    return Mappings::jsonEncode($options, $depth);
}

/**
 * Returns a closure that returns the json_encoded value as decoded value
 *
 * @param boolean $assoc
 * @param int $depth
 * @param int $options
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::jsonDecode($assoc, $options, $depth), will be removed in version 3.0
 */
function json_decode($assoc = false, $depth = 512, $options = 0)
{
    return Mappings::jsonDecode($assoc, $options, $depth);
}

/**
 * Returns a closure that applies multiple $STRATEGIES to the value and returns the results
 *
 * > $compute = function ($value, $key) {
 * >    return 'some computation result';
 * > };
 * > $list = iter\iterable([new Data(1), new Data(2), new Data(3)]);
 * > $list->map(select(['data' => null, 'id' => 'Identifier', 'desc' => 'Value.DescriptionName', 'comp' => $compute]));
 * [
 *    [
 *       'data' => Data(1),
 *       'id' => Data(1)->Identifier,
 *       'desc' => Data(1)->Value->DescriptionName,
 *       'comp' => $compute(Data(1), 0),
 *    ],
 *    ...
 *    [
 *       'data' => Data(3),
 *       'id' => Data(3)->Identifier,
 *       'desc' => Data(3)->Value->DescriptionName,
 *       'comp' => $compute(Data(3), 2),
 *    ],
 * ]
 *
 * @param array|object $mappings
 * @param null|string|\Closure $strategy
 * @param boolean $discardNull
 * @param boolean $discardEmptyContainer
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::select($mappings, $strategy, $discardNull, $discardEmptyContainer), will be removed in version 3.0
 */
function select($mappings, $strategy = null, $discardNull = false, $discardEmptyContainer = false)
{
    return Mappings::select($mappings, $strategy, $discardNull, $discardEmptyContainer);
}

/**
 * Returns a closure that returns random integer numbers between $MIN and $MAX
 *
 * @param int $min
 * @param null|int $max
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::random($min, $max), will be removed in version 3.0
 */
function random($min = 0, $max = null)
{
    return Mappings::random($min, $max);
}

/**
 * Returns a closure that returns either the class name, given an object, or otherwise the type
 *
 * @param null|string|\Closure $strategy
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::type($strategy), will be removed in version 3.0
 */
function type($strategy = null)
{
    return Mappings::type($strategy);
}

/**
 * Returns a closure that calls the mapping on each element once.
 *
 * > $compute = function ($value, $key) {
 * >    return 'some expensive computation result';
 * > };
 * > $list = iter\iterable([['id' => 42, ...], ['id' => 43, ...], ['id' => 42, ...]]);
 * > $list->map(cache($compute, 'id'));
 * [
 *    $compute(['id' => 42, ...]), // <-- calls the $compute method
 *    $compute(['id' => 43, ...]), // <-- calls the $compute method
 *    $compute(['id' => 42, ...])  // <-- does not call, instead, populates with cached values
 * ]
 *
 * @param null|string|\Closure $mapping
 * @param null|string|\Closure $strategy
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::cache($mapping, $strategy), will be removed in version 3.0
 */
function cache($mapping, $strategy = null)
{
    return Mappings::cache($mapping, $strategy);
}

/**
 * Returns a closure that returns the same value every time it is called.
 *
 * @param null|string|int|float|bool|object|array $value
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Mappings::constant($value), will be removed in version 3.0
 */
function constant($value)
{
    return Mappings::constant($value);
}

/**
 * Returns a mapping closure
 *
 * @param string $name
 * @return \Closure
 * @throws \InvalidArgumentException
 * @deprecated please use the mapping functions directly, will be removed in version 3.0
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
                return length();

            case 'key':
                return key();

            case 'select':
                return call_user_func_array('\Zicht\Itertools\mappings\select', array_slice(func_get_args(), 1));

            case 'random':
                return call_user_func_array('\Zicht\Itertools\mappings\random', array_slice(func_get_args(), 1));

            case 'type':
                return call_user_func_array('\Zicht\Itertools\mappings\type', array_slice(func_get_args(), 1));
        }
    }

    throw new \InvalidArgumentException(sprintf('$NAME "%s" is not a valid mapping.', $name));
}

/**
 * @param string $name
 * @return \Closure
 * @throws \InvalidArgumentException
 * @deprecated please use the mapping functions directly, will be removed in version 3.0
 */
function getMapping($name /* [argument, [arguments, ...] */) // phpcs:ignore Zicht.NamingConventions.Functions.GlobalNaming
{
    return call_user_func_array('\Zicht\Itertools\mappings\get_mapping', func_get_args());
}
