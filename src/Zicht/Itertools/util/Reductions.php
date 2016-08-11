<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

class Reductions
{
    public static function add()
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

    public static function sub()
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

    public static function mul()
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

    public static function min()
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

    public static function max()
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

    public static function join($glue = '')
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
            return join($glue, [$a, $b]);
        };
    }

    /**
     * @todo Remove the default parameter.  It should behave like getMappings,
     * @todo i.e. allowing parameters to pass to the specific reductions and throwing
     * @todo an exception when $NAME does not correspond to a known reduction
     * @param string $name
     * @param null $default
     * @return \Closure|null
     */
    public static function getReduction($name, $default = null)
    {
        switch ($name) {
            case 'add':
                return Reductions::add();
            case 'sub':
                return Reductions::sub();
            case 'mul':
                return Reductions::mul();
            case 'min':
                return Reductions::min();
            case 'max':
                return Reductions::max();
            case 'join':
                return Reductions::join();
            default:
                return $default;
        }
    }
}
