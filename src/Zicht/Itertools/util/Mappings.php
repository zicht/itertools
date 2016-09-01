<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

/**
 * @deprecated Use \Zicht\Itertools\mappings, will be removed in version 3.0
 */
class Mappings
{
    /**
     * @deprecated Use \Zicht\Itertools\mappings\lstrip, will be removed in version 3.0
     */
    public static function lstrip($chars = " \t\n\r\0\x0B")
    {
        return function ($value) use ($chars) {
            return ltrim($value, $chars);
        };
    }

    /**
     * @deprecated Use \Zicht\Itertools\mappings\rstrip, will be removed in version 3.0
     */
    public static function rstrip($chars = " \t\n\r\0\x0B")
    {
        return function ($value) use ($chars) {
            return rtrim($value, $chars);
        };
    }

    /**
     * @deprecated Use \Zicht\Itertools\mappings\strip, will be removed in version 3.0
     */
    public static function strip($chars = " \t\n\r\0\x0B")
    {
        return function ($value) use ($chars) {
            return trim($value, $chars);
        };
    }

    /**
     * @deprecated Use \Zicht\Itertools\mappings\length, will be removed in version 3.0
     */
    public static function length()
    {
        return function ($value) {
            return sizeof($value);
        };
    }

    /**
     * @deprecated Use \Zicht\Itertools\mappings\getMapping, will be removed in version 3.0
     */
    public static function getMapping($name /* [argument, [arguments, ...] */)
    {
        switch ($name) {
            case 'ltrim':
            case 'lstrip':
                return call_user_func_array('\Zicht\Itertools\util\Mappings::lstrip', array_slice(func_get_args(), 1));

            case 'rtrim':
            case 'rstrip':
                return call_user_func_array('\Zicht\Itertools\util\Mappings::rstrip', array_slice(func_get_args(), 1));

            case 'trim':
            case 'strip':
                return call_user_func_array('\Zicht\Itertools\util\Mappings::strip', array_slice(func_get_args(), 1));

            case 'length':
                return call_user_func_array('\Zicht\Itertools\util\Mappings::length', array_slice(func_get_args(), 1));

            default:
                throw new \InvalidArgumentException(sprintf('$NAME "%s" is not a valid mapping.', $name));
        }
    }
}
