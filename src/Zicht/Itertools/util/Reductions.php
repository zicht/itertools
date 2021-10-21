<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\util;

class Reductions
{
    /**
     * Returns a closure that adds two numbers together
     */
    public static function add(): \Closure
    {
        return function ($a, $b) {
            if (!is_numeric($a)) {
                throw new \InvalidArgumentException(sprintf('Argument $A must be numeric to perform addition, not %s', is_object($a) ? get_class($a) : gettype($a)));
            }
            if (!is_numeric($b)) {
                throw new \InvalidArgumentException(sprintf('Argument $B must be numeric to perform addition, not %s', is_object($b) ? get_class($b) : gettype($b)));
            }
            return $a + $b;
        };
    }

    /**
     * Returns a closure that subtracts one number from another
     */
    public static function sub(): \Closure
    {
        return function ($a, $b) {
            if (!is_numeric($a)) {
                throw new \InvalidArgumentException(sprintf('Argument $A must be numeric to perform subtraction, not %s', is_object($a) ? get_class($a) : gettype($a)));
            }
            if (!is_numeric($b)) {
                throw new \InvalidArgumentException(sprintf('Argument $B must be numeric to perform subtraction, not %s', is_object($b) ? get_class($b) : gettype($b)));
            }
            return $a - $b;
        };
    }

    /**
     * Returns a closure that multiplies two numbers
     */
    public static function mul(): \Closure
    {
        return function ($a, $b) {
            if (!is_numeric($a)) {
                throw new \InvalidArgumentException(sprintf('Argument $A must be numeric to perform multiplication, not %s', is_object($a) ? get_class($a) : gettype($a)));
            }
            if (!is_numeric($b)) {
                throw new \InvalidArgumentException(sprintf('Argument $B must be numeric to perform multiplication, not %s', is_object($b) ? get_class($b) : gettype($b)));
            }
            return $a * $b;
        };
    }

    /**
     * Returns a closure that returns the smallest of two numbers
     */
    public static function min(): \Closure
    {
        return function ($a, $b) {
            if (!(is_numeric($a) || $a instanceof \DateTime)) {
                throw new \InvalidArgumentException(sprintf('Argument $A must be numeric to determine minimum, not %s', is_object($a) ? get_class($a) : gettype($a)));
            }
            if (!(is_numeric($b) || $b instanceof \DateTime)) {
                throw new \InvalidArgumentException(sprintf('Argument $B must be numeric to determine minimum, not %s', is_object($b) ? get_class($b) : gettype($b)));
            }
            return $a < $b ? $a : $b;
        };
    }

    /**
     * Returns a closure that returns the largest of two numbers
     */
    public static function max(): \Closure
    {
        return function ($a, $b) {
            if (!(is_numeric($a) || $a instanceof \DateTime)) {
                throw new \InvalidArgumentException(sprintf('Argument $A must be numeric to determine maximum, not %s', is_object($a) ? get_class($a) : gettype($a)));
            }
            if (!(is_numeric($b) || $b instanceof \DateTime)) {
                throw new \InvalidArgumentException(sprintf('Argument $B must be numeric to determine maximum, not %s', is_object($b) ? get_class($b) : gettype($b)));
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
    public static function join($glue = '')
    {
        if (!is_string($glue)) {
            throw new \InvalidArgumentException(sprintf('Argument $GLUE must be a string to join, not %s', is_object($glue) ? get_class($glue) : gettype($glue)));
        }
        return function ($a, $b) use ($glue) {
            if (!is_string($a)) {
                throw new \InvalidArgumentException(sprintf('Argument $A must be a string to join, not %s', is_object($a) ? get_class($a) : gettype($a)));
            }
            if (!is_string($b)) {
                throw new \InvalidArgumentException(sprintf('Argument $B must be a string to join, not %s', is_object($b) ? get_class($b) : gettype($b)));
            }
            return \join($glue, [$a, $b]);
        };
    }
}
