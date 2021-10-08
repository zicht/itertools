<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\reductions;

use Zicht\Itertools\lib\ChainIterator;
use Zicht\Itertools\util\Reductions;

/**
 * Returns a closure that adds two numbers together
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Reductions::add(), will be removed in version 3.0
 */
function add()
{
    return Reductions::add();
}

/**
 * Returns a closure that subtracts one number from another
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Reductions::sub(), will be removed in version 3.0
 */
function sub()
{
    return Reductions::sub();
}

/**
 * Returns a closure that multiplies two numbers
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Reductions::mul(), will be removed in version 3.0
 */
function mul()
{
    return Reductions::mul();
}

/**
 * Returns a closure that returns the smallest of two numbers
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Reductions::min(), will be removed in version 3.0
 */
function min()
{
    return Reductions::min();
}

/**
 * Returns a closure that returns the largest of two numbers
 *
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Reductions::max(), will be removed in version 3.0
 */
function max()
{
    return Reductions::max();
}

/**
 * Returns a closure that concatenates two strings using $glue
 *
 * @param string $glue
 * @return \Closure
 * @deprecated Use \Zicht\Itertools\util\Reductions::join($glue), will be removed in version 3.0
 */
function join($glue = '')
{
    return Reductions::join($glue);
}

/**
 * Returns a closure that chains lists together
 *
 * > $lists = [[1, 2, 3], [4, 5, 6]]
 * > iterable($lists)->reduce(reductions\chain(), new ChainIterator())
 * results in a ChainIterator: 1, 2, 3, 4, 5, 6
 *
 * @return \Closure
 * @deprecated Use iterable($lists)->collapse(), will be removed in version 3.0
 */
function chain()
{
    return function ($chainIterator, $b) {
        if (!($chainIterator instanceof ChainIterator)) {
            throw new \InvalidArgumentException('Argument $A must be a ChainIterator.  Did your call "reduce" with "new ChainIterator()" as the initial parameter?');
        }

        $chainIterator->extend($b);
        return $chainIterator;
    };
}

/**
 * Returns a reduction closure
 *
 * @param string $name
 * @return \Closure
 * @throws \InvalidArgumentException
 * @deprecated please use the reduction functions directly, will be removed in version 3.0
 */
function get_reduction($name)
{
    if (is_string($name)) {
        switch ($name) {
            case 'add':
                return add();
            case 'sub':
                return sub();
            case 'mul':
                return mul();
            case 'min':
                return min();
            case 'max':
                return max();
            case 'join':
                return call_user_func_array('\Zicht\Itertools\reductions\join', array_slice(func_get_args(), 1));
            case 'chain':
                return chain();
        }
    }

    throw new \InvalidArgumentException(sprintf('$NAME "%s" is not a valid reduction.', $name));
}

/**
 * Returns a reduction closure
 *
 * @param mixed $name
 * @return \Closure
 * @throws \InvalidArgumentException
 * @deprecated please use the reduction functions directly, will be removed in version 3.0
 */
function getReduction($name) // phpcs:ignore Zicht.NamingConventions.Functions.GlobalNaming
{
    return call_user_func_array('\Zicht\Itertools\reductions\get_reduction', func_get_args());
}
