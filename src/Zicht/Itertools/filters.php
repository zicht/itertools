<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\filters;

/**
 * Returns a filter closure that only accepts values that are instances of $CLASS.
 *
 * @param string $class
 * @return \Closure
 */
function type($class)
{
    return function ($value) use ($class) {
        return $value instanceof $class;
    };
}
