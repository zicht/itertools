<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

/**
 * @deprecated Use \Zicht\Itertools\conversions, will be removed in version 3.0
 */
class Conversions
{
    /**
     * Transforms anything into an Iterator or throws an InvalidArgumentException
     *
     * > mixedToIterator([1, 2, 3])
     * 1 2 3
     *
     * > mixedToIterator('foo')
     * f o o
     *
     * @deprecated Use \Zicht\Itertools\conversions\mixedToIterator, will be removed in version 3.0
     * @param array|string|\Iterator $iterable
     * @return \Iterator
     */
    public static function mixedToIterator($iterable)
    {
        return \Zicht\Itertools\conversions\mixedToIterator($iterable);
    }

    /**
     * Try to transforms something into a Closure.
     *
     * When $CLOSURE is null the returned Closure behaves like an identity function,
     * i.e. it will return the value that it is given.
     *
     * @deprecated Use \Zicht\Itertools\conversions\mixedToClosure, will be removed in version 3.0
     * @param null|\Closure $closure
     * @return \Closure
     */
    public static function mixedToClosure($closure)
    {
        return \Zicht\Itertools\conversions\mixedToClosure($closure);
    }

    /**
     * Try to transforms something into a Closure that gets a value from $STRATEGY.
     *
     * When $STRATEGY is null the returned Closure behaves like an identity function,
     * i.e. it will return the value that it is given.
     *
     * When $STRATEGY is a string the returned Closure tries to find a properties,
     * methods, or array indexes named by the string.  Multiple property, method,
     * or index names can be separated by a dot.
     * - 'getId'
     * - 'getData.key'
     *
     * When $STRATEGY is callable it is converted into a Closure (see mixedToClosure).
     *
     * @deprecated Use \Zicht\Itertools\conversions\mixedToValueGetter, will be removed in version 3.0
     * @param null|string|\Closure $strategy
     * @return \Closure
     */
    public static function mixedToValueGetter($strategy)
    {
        return \Zicht\Itertools\conversions\mixedToValueGetter($strategy);
    }
}
