<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

use Zicht\Itertools;

/**
 * @deprecated Use \Zicht\Itertools\reductions, will be removed in version 3.0
 */
class Reductions
{
    /**
     * @deprecated Use \Zicht\Itertools\reductions\add, will be removed in version 3.0
     */
    public static function add()
    {
        return Itertools\reductions\add();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\sub, will be removed in version 3.0
     */
    public static function sub()
    {
        return Itertools\reductions\sub();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\mul, will be removed in version 3.0
     */
    public static function mul()
    {
        return Itertools\reductions\mul();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\min, will be removed in version 3.0
     */
    public static function min()
    {
        return Itertools\reductions\min();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\max, will be removed in version 3.0
     */
    public static function max()
    {
        return Itertools\reductions\max();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\join, will be removed in version 3.0
     */
    public static function join($glue = '')
    {
        return Itertools\reductions\join($glue);
    }

    /**
     * @todo Remove the default parameter.  It should behave like getMappings,
     * @todo i.e. allowing parameters to pass to the specific reductions and throwing
     * @todo an exception when $NAME does not correspond to a known reduction
     * @deprecated Use \Zicht\Itertools\reductions\getReduction, note that this has a different API, will be removed in version 3.0
     * @param string $name
     * @param null $default
     * @return \Closure|null
     */
    public static function getReduction($name, $default = null)
    {
        switch ($name) {
            case 'add':
                return Itertools\reductions\add();
            case 'sub':
                return Itertools\reductions\sub();
            case 'mul':
                return Itertools\reductions\mul();
            case 'min':
                return Itertools\reductions\min();
            case 'max':
                return Itertools\reductions\max();
            case 'join':
                return Itertools\reductions\join();
            default:
                return $default;
        }
    }
}
