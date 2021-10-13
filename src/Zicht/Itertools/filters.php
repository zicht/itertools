<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\filters;

use Zicht\Itertools;
use Zicht\Itertools\util\Conversions;
use Zicht\Itertools\util\Filters;

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
 * > $list = iterable([['key' => new Foo()], ['key' => new Bar()], ['key' => new Moo()]]);
 * > $result = $list->filter(type(Bar::class, 'key'));
 * > // {1: ['key' => Bar]}
 *
 * @param string $class
 * @param null|string|\Closure $strategy
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Filters::type($class, $strategy), will be removed in version 3.0
 */
function type($class, $strategy = null)
{
    return Filters::type($class, $strategy);
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
 * @deprecated Use \Zicht\Itertools\util\Filters::type($heystack, $strategy, $strict), will be removed in version 3.0
 */
function in($haystack, $strategy = null, $strict = false)
{
    return Filters::in($haystack, $strategy, $strict);
}

/**
 * Returns a filter closure that only accepts values that are not in $HAYSTACK.
 *
 * @param array|string|\Iterator $haystack
 * @param null|string|\Closure $strategy
 * @param boolean $strict
 * @return \Closure
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
    $strategy = Conversions::mixedToValueGetter($strategy);
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
 * @deprecated Use \Zicht\Itertools\util\Filters::equals($heystack, $strategy, $strict), will be removed in version 3.0
 */
function equals($expected, $strategy = null, $strict = false)
{
    return Filters::equals($expected, $strategy, $strict);
}

/**
 * Returns a filter closure that only accepts values that are after $EXPECTED
 *
 * For example, the following will return a list where only
 * returns entries that are after 2020-04-01:
 * > $list = iterable([new \DateTime('2020-01-01'), new \DateTime('2020-03-01'), new \DateTime('2020-05-01')])
 * > $result = $list->filer(after(new \DateTimeImmutable('2020-04-01')));
 * > // [new \DateTime('2020-05-01')]
 *
 * @param \DateTimeInterface|int|float $expected
 * @param null|string|\Closure $strategy
 * @param bool $orEqual
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Filters::after($expected, $strategy, $orEqual), will be removed in version 3.0
 */
function after($expected, $strategy = null, $orEqual = false)
{
    return Filters::after($expected, $strategy, $orEqual);
}

/**
 * Returns a filter closure that only accepts values that are before $EXPECTED
 *
 * For example, the following will return a list where only
 * returns entries that are before 2020-04-01:
 * > $list = iterable([new \DateTime('2020-01-01'), new \DateTime('2020-03-01'), new \DateTime('2020-05-01')])
 * > $result = $list->filer(before(new \DateTimeImmutable('2020-04-01')));
 * > // [new \DateTime('2020-01-01'), new \DateTime('2020-03-01')]
 *
 * @param \DateTimeInterface|int|float $expected
 * @param null|string|\Closure $strategy
 * @param bool $orEqual
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Filters::before($expected, $strategy, $orEqual), will be removed in version 3.0
 */
function before($expected, $strategy = null, $orEqual = false)
{
    return Filters::before($expected, $strategy, $orEqual);
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
 * @deprecated Use \Zicht\Itertools\util\Filters::not($strategy), will be removed in version 3.0
 */
function not($strategy = null)
{
    return Filters::not($strategy);
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
 * @deprecated Use \Zicht\Itertools\util\Filters::match($pattern, $strategy), will be removed in version 3.0
 */
function match($pattern, $strategy = null)
{
    return Filters::match($pattern, $strategy);
}
