<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\reductions;

use Zicht\Itertools\lib\ChainIterator;

/**
 * Returns a closure that adds two numbers together
 *
 * @return \Closure
 */
function add()
{
    return function ($a, $b) {
        if (!is_numeric($a)) {
            throw new \InvalidArgumentException('Argument $A must be numeric to perform addition');
        }
        if (!is_numeric($b)) {
            throw new \InvalidArgumentException('Argument $B must be numeric to perform addition');
        }
        return $a + $b;
    };
}

/**
 * Returns a closure that subtracts one number from another
 *
 * @return \Closure
 */
function sub()
{
    return function ($a, $b) {
        if (!is_numeric($a)) {
            throw new \InvalidArgumentException('Argument $A must be numeric to perform subtraction');
        }
        if (!is_numeric($b)) {
            throw new \InvalidArgumentException('Argument $B must be numeric to perform subtraction');
        }
        return $a - $b;
    };
}

/**
 * Returns a closure that multiplies two numbers
 *
 * @return \Closure
 */
function mul()
{
    return function ($a, $b) {
        if (!is_numeric($a)) {
            throw new \InvalidArgumentException('Argument $A must be numeric to perform multiplication');
        }
        if (!is_numeric($b)) {
            throw new \InvalidArgumentException('Argument $B must be numeric to perform multiplication');
        }
        return $a * $b;
    };
}

/**
 * Returns a closure that returns the smallest of two numbers
 *
 * @return \Closure
 */
function min()
{
    return function ($a, $b) {
        if (!is_numeric($a)) {
            throw new \InvalidArgumentException('Argument $A must be numeric to determine minimum');
        }
        if (!is_numeric($b)) {
            throw new \InvalidArgumentException('Argument $B must be numeric to determine minimum');
        }
        return $a < $b ? $a : $b;
    };
}

/**
 * Returns a closure that returns the largest of two numbers
 *
 * @return \Closure
 */
function max()
{
    return function ($a, $b) {
        if (!is_numeric($a)) {
            throw new \InvalidArgumentException('Argument $A must be numeric to determine maximum');
        }
        if (!is_numeric($b)) {
            throw new \InvalidArgumentException('Argument $B must be numeric to determine maximum');
        }
        return $a < $b ? $b : $a;
    };
}

/**
 * Returns a closure that concatenates two strings using $glue
 *
 * @param string $glue
 * @return \Closure
 */
function join($glue = '')
{
    if (!is_string($glue)) {
        throw new \InvalidArgumentException('Argument $GLUE must be a string to join');
    }
    return function ($a, $b) use ($glue) {
        if (!is_string($a)) {
            throw new \InvalidArgumentException('Argument $A must be a string to join');
        }
        if (!is_string($b)) {
            throw new \InvalidArgumentException('Argument $B must be a string to join');
        }
        return \join($glue, [$a, $b]);
    };
}

/**
 * Returns a closure that chains lists together
 *
 * > $lists = [[1, 2, 3], [4, 5, 6]]
 * > iterable($lists)->reduce(reductions\chain(), new ChainIterator())
 * results in a ChainIterator: 1, 2, 3, 4, 5, 6
 *
 * @return \Closure
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
 *
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
 * @deprecated please use the reduction functions directly, will be removed in version 3.0
 */
function getReduction($name)
{
    return call_user_func_array('\Zicht\Itertools\reductions\get_reduction', func_get_args());
}
