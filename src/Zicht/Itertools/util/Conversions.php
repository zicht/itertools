<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

use Zicht\Itertools\conversions as conversion_functions;

/**
 * Class Conversions
 *
 * @deprecated Use \Zicht\Itertools\conversions, will be removed in version 3.0
 * @package Zicht\Itertools\util
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
     * @param array|string|\Iterator $iterable
     * @return \Iterator
     * @deprecated Use \Zicht\Itertools\conversions\mixed_to_iterator, will be removed in version 3.0
     */
    public static function mixedToIterator($iterable)
    {
        return conversion_functions\mixed_to_iterator($iterable);
    }

    /**
     * Try to transforms something into a Closure.
     *
     * When $CLOSURE is null the returned Closure behaves like an identity function,
     * i.e. it will return the value that it is given.
     *
     * @param null|\Closure $closure
     * @return \Closure
     * @deprecated Use \Zicht\Itertools\conversions\mixed_to_closure, will be removed in version 3.0
     */
    public static function mixedToClosure($closure)
    {
        return conversion_functions\mixed_to_closure($closure);
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
     * @param null|string|\Closure $strategy
     * @return \Closure
     * @deprecated Use \Zicht\Itertools\conversions\mixed_to_value_getter, will be removed in version 3.0
     */
    public static function mixedToValueGetter($strategy)
    {
        return conversion_functions\mixed_to_value_getter($strategy);
    }
}
