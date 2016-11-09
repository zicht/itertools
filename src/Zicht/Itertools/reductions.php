<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\reductions;

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
 * @param string $name
 * @return \Closure
 * @throws \InvalidArgumentException
 */
function get_reduction($name /* [argument, [arguments, ...] */)
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
                return call_user_func_array('\Zicht\Itertools\util\reductions\join', array_slice(func_get_args(), 1));
        }
    }

    throw new \InvalidArgumentException(sprintf('$NAME "%s" is not a valid reduction.', $name));
}

/**
 * @deprecated use get_reduction, will be removed in version 3.0
 */
function getReduction($name /* [argument, [arguments, ...] */)
{
    return call_user_func_array('\Zicht\Itertools\reductions\get_reduction', func_get_args());
}
