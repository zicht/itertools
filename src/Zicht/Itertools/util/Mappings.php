<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\util;

class Mappings
{
    /**
     * Returns a closure that strips any matching $chars from the left of the input string
     */
    public static function lstrip(string $chars = " \t\n\r\0\x0B"): \Closure
    {
        if (!is_string($chars)) {
            throw new \TypeError('$chars must be a string');
        }
        return function ($value) use ($chars) {
            return ltrim($value, $chars);
        };
    }

    /**
     * Returns a closure that strips any matching $chars from the right of the input string
     */
    public static function rstrip(string $chars = " \t\n\r\0\x0B"): \Closure
    {
        if (!is_string($chars)) {
            throw new \TypeError('$chars must be a string');
        }
        return function ($value) use ($chars) {
            return rtrim($value, $chars);
        };
    }

    /**
     * Returns a closure that strips any matching $chars from the left and right of the input string
     */
    public static function strip(string $chars = " \t\n\r\0\x0B"): \CLosure
    {
        if (!is_string($chars)) {
            throw new \TypeError('$chars must be a string');
        }
        return function ($value) use ($chars) {
            return trim($value, $chars);
        };
    }

    /**
     * Returns a closure that returns the length of the input
     */
    public static function length(): \Closure
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
     */
    public static function key(): \Closure
    {
        return fn($value, $key) => $key;
    }

    /**
     * Returns a closure that returns the string value lower cased
     */
    public static function lower(): \Closure
    {
        return fn($value) => strtolower($value);
    }

    /**
     * Returns a closure that returns the string value upper cased
     */
    public static function upper(): \Closure
    {
        return fn($value) => strtoupper($value);
    }

    /**
     * Returns a closure that returns the value cast to a string
     */
    public static function string(): \Closure
    {
        return fn($value) => (string)$value;
    }

    /**
     * Returns a closure that returns the value as a json_encoded string
     */
    public static function jsonEncode(int $options = 0, int $depth = 512): \Closure
    {
        return function ($value) use ($options, $depth) {
            return \json_encode($value, $options, $depth);
        };
    }

    /**
     * Returns a closure that returns the json_encoded value as decoded value
     */
    public static function jsonDecode(bool $associative = false, int $options = 0, int $depth = 512): \Closure
    {
        return function ($value) use ($associative, $options, $depth) {
            return \json_decode($value, $associative, $depth, $options);
        };
    }

    /**
     * Returns a closure that applies multiple mappings to the value and returns the results
     *
     * > $compute = function ($value, $key) {
     * >    return 'some computation result';
     * > };
     * > $list = iterable([new Data(1), new Data(2), new Data(3)]);
     * > $list->map(Mappings::select(['data' => null, 'id' => 'Identifier', 'desc' => 'Value.DescriptionName', 'comp' => $compute]));
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
     */
    public static function select($mappings, $strategy = null, bool $discardNull = false, bool $discardEmptyContainer = false): \Closure
    {
        $castToObject = is_object($mappings);
        $mappings = array_map('\Zicht\Itertools\util\Conversions::mixedToValueGetter', (array)$mappings);
        $strategy = Conversions::mixedToValueGetter($strategy);

        return function ($value, $key) use ($mappings, $strategy, $discardNull, $discardEmptyContainer, $castToObject) {
            $value = $strategy($value);
            $res = [];
            foreach ($mappings as $strategyKey => $strategy) {
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
            return $castToObject ? (object)$res : $res;
        };
    }

    /**
     * Returns a closure that returns random integer numbers between $MIN and $MAX
     */
    public static function random(int $min = 0, ?int $max = null): \Closure
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
    public static function type($strategy = null): \Closure
    {
        $strategy = Conversions::mixedToValueGetter($strategy);
        return function ($value) use ($strategy) {
            $value = $strategy($value);
            return is_object($value) ? get_class($value) : gettype($value);
        };
    }

    /**
     * Returns a closure that calls the mapping on each element once.
     *
     * > $compute = function ($value, $key) {
     * >    return 'some expensive computation result';
     * > };
     * > $list = iterable([['id' => 42, ...], ['id' => 43, ...], ['id' => 42, ...]]);
     * > $list->map(Mappings::cache($compute, 'id'));
     * [
     *    $compute(['id' => 42, ...]), // <-- calls the $compute method
     *    $compute(['id' => 43, ...]), // <-- calls the $compute method
     *    $compute(['id' => 42, ...])  // <-- does not call, instead, populates with cached values
     * ]
     *
     * @param null|string|\Closure $mapping
     * @param null|string|\Closure $strategy
     * @return \Closure
     */
    public static function cache($mapping, $strategy = null): \Closure
    {
        $mapping = Conversions::mixedToValueGetter($mapping);
        $strategy = Conversions::mixedToValueGetter($strategy);
        $cache = [];
        return function ($value, $key = null) use ($mapping, $strategy, &$cache) {
            $cacheKey = \json_encode($strategy($value, $key));
            if (!array_key_exists($cacheKey, $cache)) {
                $cache[$cacheKey] = $mapping($value, $key);
            }
            return $cache[$cacheKey];
        };
    }

    /**
     * Returns a closure that returns the same value every time it is called.
     *
     * @param null|string|int|float|bool|object|array $value
     * @return \Closure
     */
    public static function constant($value): \Closure
    {
        return function () use ($value) {
            return $value;
        };
    }
}
