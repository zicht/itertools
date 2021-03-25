<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

use Doctrine\Common\Collections\Collection;
use Zicht\Itertools\lib\StringIterator;
use function Zicht\Itertools\conversions\mixed_to_closure;

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
     */
    public static function mixedToIterator($iterable)
    {
        // NULL is often used to indicate that nothing is there,
        // for robustness we will deal with NULL as it is an empty array
        if (is_null($iterable)) {
            $iterable = new \ArrayIterator([]);
        }

        // an array is *not* an instance of Traversable (as it is not an
        // object and hence can not 'implement Traversable')
        if (is_array($iterable)) {
            $iterable = new \ArrayIterator($iterable);
        }

        // a string is considered iterable in Python
        if (is_string($iterable)) {
            $iterable = new StringIterator($iterable);
        }

        // a doctrine Collection (i.e. Array or Persistent) is also an iterator
        if ($iterable instanceof Collection) {
            $iterable = $iterable->getIterator();
        }

        if ($iterable instanceof \Traversable and !($iterable instanceof \Iterator)) {
            $iterable = new \IteratorIterator($iterable);
        }

        // by now it should be an Iterator, otherwise throw an exception
        if (!($iterable instanceof \Iterator)) {
            throw new \InvalidArgumentException('Argument $ITERABLE must be a Traversable');
        }

        return $iterable;
    }

    /**
     * Try to transforms something into a Closure.
     *
     * When $closure is null the returned Closure behaves like an identity function,
     * i.e. it will return the value that it is given.
     *
     * @param null|\Closure $closure
     * @return \Closure
     */
    public static function mixedToClosure($closure)
    {
        if (is_null($closure)) {
            return function ($value) {
                return $value;
            };
        }

        if (!($closure instanceof \Closure)) {
            // A \Closure is always callable, but a callable is not always a \Closure.
            // Checking within this if statement is a slight optimization, preventing an unnecessary function wrap
            if (is_callable($closure)) {
                $closure = function () use ($closure) {
                    return call_user_func_array($closure, func_get_args());
                };
            } else {
                throw new \InvalidArgumentException('Argument $CLOSURE must be a Closure');
            }
        }

        return $closure;
    }

    /**
     * Try to transforms something into a Closure that gets a value from $strategy.
     *
     * When $strategy is null the returned Closure behaves like an identity function,
     * i.e. it will return the value that it is given.
     *
     * When $strategy is callable it is converted into a Closure (see mixedToClosure).
     *
     * When $strategy is a string the returned Closure tries to find properties,
     * methods, or array indexes named by the string.  Multiple property, method,
     * or index names can be separated by a dot.  The same behavior as Twig is
     * used, see http://twig.sensiolabs.org/doc/2.x/templates.html#variables
     *
     * @param null|string|\Closure $strategy
     * @return \Closure
     */
    public static function mixedToValueGetter($strategy)
    {
        if (is_string($strategy)) {
            $keyParts = explode('.', $strategy);
            $strategy = function ($value) use ($keyParts) {
                foreach ($keyParts as $keyPart) {
                    if (is_array($value) && array_key_exists($keyPart, $value)) {
                        $value = $value[$keyPart];
                        continue;
                    }

                    if (is_object($value)) {
                        // property_exists does not distinguish between public, protected, or private properties, hence we need to use reflection
                        $reflection = new \ReflectionObject($value);
                        if ($reflection->hasProperty($keyPart)) {
                            $property = $reflection->getProperty($keyPart);
                            if ($property->isPublic()) {
                                $value = $property->getValue($value);
                                continue;
                            }
                        }

                        foreach (['', 'get', 'is', 'has'] as $prefix) {
                            $method = sprintf('%s%s', $prefix, $keyPart);
                            if (is_callable([$value, $method])) {
                                $value = call_user_func([$value, $method]);
                                continue 2;
                            }
                        }

                        if (method_exists($value, '__get')) {
                            $value = $value->$keyPart;
                            continue;
                        }
                    }

                    // no match found
                    $value = null;
                    break;
                }

                return $value;
            };
        }

        return self::mixedToClosure($strategy);
    }
}
