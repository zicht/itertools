<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\mappings;

use Zicht\Itertools\conversions;

/**
 * Returns a closure that strips any matching $CHARS from the left of the input string
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
 * Returns a closure that strips any matching $CHARS from the right of the input string
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
 * Returns a closure that strips any matching $CHARS from the left and right of the input string
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
 * Returns a closure that returns the length of the input
 *
 * @return \Closure
 */
function length()
{
    return function ($value) {
        if (is_null($value)) {
            return 0;
        }

        if (is_string($value)) {
            return strlen($value);
        }

        return sizeof($value);
    };
}

/**
 * Returns a closure that returns the key
 *
 * @return \Closure
 */
function key()
{
    return function ($value, $key) {
        return $key;
    };
}

/**
 * Returns a closure that returns the string value lower cased
 *
 * @return \Closure
 */
function lower()
{
    return function ($value) {
        return strtolower($value);
    };
}

/**
 * Returns a closure that returns the string value upper cased
 *
 * @return \Closure
 */
function upper()
{
    return function ($value) {
        return strtoupper($value);
    };
}

/**
 * Returns a closure that returns the value as a json_encoded string
 *
 * @param integer $options
 * @param integer $depth
 * @return \Closure
 */
function json_encode($options = 0, $depth = 512)
{
    return function ($value) use ($options, $depth) {
        return \json_encode($value, $options, $depth);
    };
}

/**
 * Returns a closure that returns the json_encoded value as decoded value
 *
 * @param boolean $assoc
 * @param integer $depth
 * @param integer $options
 * @return \Closure
 */
function json_decode($assoc = false, $depth = 512, $options = 0)
{
    return function ($value) use ($assoc, $depth, $options) {
        return \json_decode($value, $assoc, $depth, $options);
    };
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
 * @param array $strategies
 * @param null|string|\Closure $strategy
 * @param boolean $discardNull
 * @param boolean $discardEmptyContainer
 * @return \Closure
 */
function select(array $strategies, $strategy = null, $discardNull = false, $discardEmptyContainer = false)
{
    $strategies = array_map('\Zicht\Itertools\conversions\mixed_to_value_getter', $strategies);
    $strategy = conversions\mixed_to_value_getter($strategy);

    return function ($value, $key) use ($strategies, $strategy, $discardNull, $discardEmptyContainer) {
        $value = $strategy($value);
        $res = [];
        foreach ($strategies as $strategyKey => $strategy) {
            $res[$strategyKey] = $strategy($value, $key);
        }
        if ($discardNull || $discardEmptyContainer) {
            $res = array_filter(
                $res,
                function ($value) use ($discardNull, $discardEmptyContainer) {
                    if (null === $value) {
                        return !$discardNull;
                    }

                    if (is_array($value) && 0 === sizeof($value)) {
                        return !$discardEmptyContainer;
                    }

                    return true;
                }
            );
        }
        return $res;
    };
}

/**
 * Returns a closure that returns random integer numbers between $MIN and $MAX
 *
 * @param int $min
 * @param null|int $max
 * @return \Closure
 */
function random($min = 0, $max = null)
{
    if (null === $max) {
        $max = getrandmax();
    }

    return function () use ($min, $max) {
        return rand($min, $max);
    };
}

/**
 * Returns a closure that returns either the class name, given an object, or otherwise the type
 *
 * @param null|string|\Closure $strategy
 * @return \Closure
 */
function type($strategy = null)
{
    $strategy = conversions\mixed_to_value_getter($strategy);
    return function ($value) use ($strategy) {
        $value = $strategy($value);
        return is_object($value) ? get_class($value) : gettype($value);
    };
}

/**
 * Returns a mapping closure
 *
 * @param string $name
 * @return \Closure
 * @throws \InvalidArgumentException
 *
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
 *
 * @deprecated please use the mapping functions directly, will be removed in version 3.0
 */
function getMapping($name /* [argument, [arguments, ...] */)
{
    return call_user_func_array('\Zicht\Itertools\mappings\get_mapping', func_get_args());
}
