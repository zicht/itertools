<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

class Mappings
{
    public static function lstrip($chars = " \t\n\r\0\x0B")
    {
        return function ($value) use ($chars) {
            return ltrim($value, $chars);
        };
    }

    public static function rstrip($chars = " \t\n\r\0\x0B")
    {
        return function ($value) use ($chars) {
            return rtrim($value, $chars);
        };
    }

    public static function strip($chars = " \t\n\r\0\x0B")
    {
        return function ($value) use ($chars) {
            return trim($value, $chars);
        };
    }

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

            default:
                return null;
        }
    }
}
