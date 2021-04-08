<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\util;

use function Zicht\Itertools\iterable;

class Filters
{
    /**
     * Returns a filter closure that only accepts values that are instances of $class.
     *
     * For example, the following will return a list where all items
     * are instances of class Bar:
     * > $list = iterable([new Foo(), new Bar(), new Moo()]);
     * > $result = $list->filter(Filters::type(Bar::class));
     * > // {1: Bar}
     *
     * For example, the following will return a list where all items
     * have a property or array index 'key' that is an instance
     * of class Foo:
     * > $list = iterable([['key' => new Foo()], ['key' => new Bar()], ['key' => new Moo()]]);
     * > $result = $list->filter(Filters::type(Bar::class, 'key'));
     * > // {1: ['key' => Bar]}
     *
     * @param string $class
     * @param null|string|\Closure $strategy
     * @return \Closure
     */
    public static function type($class, $strategy = null)
    {
        if (!is_string($class)) {
            throw new \TypeError('$class must be a string');
        }
        $strategy = Conversions::mixedToValueGetter($strategy);
        return function ($value, $key = null) use ($class, $strategy) {
            return $strategy($value, $key) instanceof $class;
        };
    }

    /**
     * Returns a filter closure that only accepts values that are in $haystack.
     *
     * For example, the following will return a list where all items
     * are either 'b' or 'c':
     * > $list = iterable(['a', 'b', 'c', 'd', 'e']);
     * > $result = $list->filter(Filters::in(['b', 'c']));
     * > // {1: 'b', 2: 'c'}
     *
     * For example, the following will return a list where all items
     * have a property or array index 'key' that is either 'b' or 'c':
     * > $list = iterable([['key' => 'a'], ['key' => 'b'], ['key' => 'c'], ['key' => 'd'], ['key' => 'e']]);
     * > $result = $list->filter(Filters::in(['b', 'c'], 'key'));
     * > // {1: ['key' => 'b'], 2: ['key' => 'c']}
     *
     * @param null|array|string|\Iterator $haystack
     * @param null|string|\Closure $strategy
     * @param boolean $strict
     * @return \Closure
     */
    public static function in($haystack, $strategy = null, $strict = false)
    {
        if (!is_bool($strict)) {
            throw new \TypeError('$strict must be a boolean');
        }
        if (!is_array($haystack)) {
            $haystack = iterable($haystack)->values();
        }
        $strategy = Conversions::mixedToValueGetter($strategy);
        return function ($value, $key = null) use ($haystack, $strategy, $strict) {
            return in_array($strategy($value, $key), $haystack, $strict);
        };
    }

    /**
     * Returns a filter closure that only accepts values that are equal to $expected
     *
     * For example, the following will return a list where all items
     * equal 'bar':
     * > $list = iterable(['foo', 'bar']);
     * > $result = $list->filter(Filters::equals('bar'));
     * > // {1: 'bar'}
     *
     * For example, the following will return a list where all items
     * have a property or array index 'foo' that equals 'bar':
     * > $list = iterable([['key' => 'foo'], ['key' => 'bar']]);
     * > $result = $list->filter(Filters::equals('bar', 'key'));
     * > // {1: ['key' => 'bar']}
     *
     * @param mixed $expected
     * @param null|string|\Closure $strategy
     * @param boolean $strict
     * @return \Closure
     */
    public static function equals($expected, $strategy = null, $strict = false)
    {
        if (!is_bool($strict)) {
            throw new \TypeError('$strict must be a boolean');
        }
        $strategy = Conversions::mixedToValueGetter($strategy);
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
     * Returns a filter closure that only accepts values that are after $expected
     *
     * For example, the following will return a list where only
     * returns entries that are after 2020-04-01:
     * > $list = iterable([new \DateTime('2020-01-01'), new \DateTime('2020-03-01'), new \DateTime('2020-05-01')])
     * > $result = $list->filer(Filters::after(new \DateTimeImmutable('2020-04-01')));
     * > // [new \DateTime('2020-05-01')]
     *
     * @param \DateTimeInterface|int|float $expected
     * @param null|string|\Closure $strategy
     * @param bool $orEqual
     * @return \Closure
     */
    public static function after($expected, $strategy = null, $orEqual = false)
    {
        if (!is_bool($orEqual)) {
            throw new \TypeError('$orEqual must be a boolean');
        }

        $strategy = Conversions::mixedToValueGetter($strategy);

        // Support DateTimeInterface
        if ($expected instanceof \DateTimeInterface) {
            return function ($value, $key = null) use ($expected, $strategy, $orEqual) {
                $value = $strategy($value, $key);
                // Try to convert strings that look like ISO date format
                if (is_string($value) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $value)) {
                    try {
                        $value = new \DateTimeImmutable($value);
                    } catch (\Exception $exception) {
                    }
                }
                return $value instanceof \DateTimeInterface && ($orEqual ? $expected <= $value : $expected < $value);
            };
        }

        // Support numbers
        if (is_int($expected) || is_float($expected)) {
            return function ($value, $key = null) use ($expected, $strategy, $orEqual) {
                $value = $strategy($value, $key);
                return (is_int($value) || is_float($value)) && ($orEqual ? $expected <= $value : $expected < $value);
            };
        }

        // Everything else fails
        return function () {
            return false;
        };
    }

    /**
     * Returns a filter closure that only accepts values that are before $expected
     *
     * For example, the following will return a list where only
     * returns entries that are before 2020-04-01:
     * > $list = iterable([new \DateTime('2020-01-01'), new \DateTime('2020-03-01'), new \DateTime('2020-05-01')])
     * > $result = $list->filer(Filters::before(new \DateTimeImmutable('2020-04-01')));
     * > // [new \DateTime('2020-01-01'), new \DateTime('2020-03-01')]
     *
     * @param \DateTimeInterface|int|float $expected
     * @param null|string|\Closure $strategy
     * @param bool $orEqual
     * @return \Closure
     */
    public static function before($expected, $strategy = null, $orEqual = false)
    {
        if (!is_bool($orEqual)) {
            throw new \TypeError('$orEqual must be a boolean');
        }

        $strategy = Conversions::mixedToValueGetter($strategy);

        // Support DateTimeInterface
        if ($expected instanceof \DateTimeInterface) {
            return function ($value, $key = null) use ($expected, $strategy, $orEqual) {
                $value = $strategy($value, $key);
                // Try to convert strings that look like ISO date format
                if (is_string($value) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $value)) {
                    try {
                        $value = new \DateTimeImmutable($value);
                    } catch (\Exception $exception) {
                    }
                }
                return $value instanceof \DateTimeInterface && ($orEqual ? $expected >= $value : $expected > $value);
            };
        }

        // Support numbers
        if (is_int($expected) || is_float($expected)) {
            return function ($value, $key = null) use ($expected, $strategy, $orEqual) {
                $value = $strategy($value, $key);
                return (is_int($value) || is_float($value)) && ($orEqual ? $expected >= $value : $expected > $value);
            };
        }

        // Everything else fails
        return function () {
            return false;
        };
    }

    /**
     * Returns a filter closure that inverts the value
     *
     * For example, the following will return a list where none
     * of the items equal 'bar'
     * > $list = iterable(['foo', 'bar']);
     * > $result = $list->filter(Filters::not(equals('bar')));
     * > // {0: 'foo'}
     *
     * @param null|string|\Closure $strategy
     * @return \Closure
     */
    public static function not($strategy = null)
    {
        $strategy = Conversions::mixedToValueGetter($strategy);
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
     * > $result = $list->filter(Filters::match('/bar/i'));
     * > // {1: '-= bar =-'}
     *
     * @param string $pattern
     * @param null|string|\Closure $strategy
     * @return \Closure
     */
    public static function match($pattern, $strategy = null)
    {
        if (!is_string($pattern)) {
            throw new \TypeError('$pattern must be a string');
        }

        $strategy = Conversions::mixedToValueGetter($strategy);
        return function ($value, $key = null) use ($pattern, $strategy) {
            return (bool)preg_match($pattern, $strategy($value, $key));
        };
    }
}
