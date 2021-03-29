<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\conversions;

use Zicht\Itertools\util\Conversions;

/**
 * @param array|string|\Iterator $iterable
 * @return \Iterator
 * @deprecated Use \Zicht\Itertools\util\Conversions::mixedToIterator, will be removed in version 3.0
 */
function mixed_to_iterator($iterable)
{
    return Conversions::mixedToIterator($iterable);
}

/**
 * @param null|array|\Closure $closure
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Conversions::mixedToClosure, will be removed in version 3.0
 */
function mixed_to_closure($closure)
{
    return Conversions::mixedToClosure($closure);
}

/**
 * @param null|string|\Closure $strategy
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Conversions::mixedToClosure, will be removed in version 3.0
 */
function mixed_to_value_getter($strategy)
{
    return Conversions::mixedToValueGetter($strategy);
}

/**
 * @param array|string|\Iterator $iterable
 * @return \Iterator
 * @deprecated Use \Zicht\Itertools\util\Conversions::mixedToIterator, will be removed in version 3.0
 */
function mixedToIterator($iterable) // phpcs:ignore Zicht.NamingConventions.Functions.GlobalNaming
{
    return Conversions::mixedToIterator($iterable);
}

/**
 * @param null|\Closure $closure
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Conversions::mixedToClosure, will be removed in version 3.0
 */
function mixedToClosure($closure) // phpcs:ignore Zicht.NamingConventions.Functions.GlobalNaming
{
    return Conversions::mixedToClosure($closure);
}

/**
 * @param null|string|\Closure $strategy
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Conversions::mixedToClosure, will be removed in version 3.0
 */
function mixedToValueGetter($strategy) // phpcs:ignore Zicht.NamingConventions.Functions.GlobalNaming
{
    return Conversions::mixedToValueGetter($strategy);
}
