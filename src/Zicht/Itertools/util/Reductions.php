<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\util;

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
        return \Zicht\Itertools\reductions\add();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\sub, will be removed in version 3.0
     */
    public static function sub()
    {
        return \Zicht\Itertools\reductions\sub();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\mul, will be removed in version 3.0
     */
    public static function mul()
    {
        return \Zicht\Itertools\reductions\mul();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\min, will be removed in version 3.0
     */
    public static function min()
    {
        return \Zicht\Itertools\reductions\min();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\max, will be removed in version 3.0
     */
    public static function max()
    {
        return \Zicht\Itertools\reductions\max();
    }

    /**
     * @deprecated Use \Zicht\Itertools\reductions\join, will be removed in version 3.0
     */
    public static function join($glue = '')
    {
        return \Zicht\Itertools\reductions\join($glue);
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
                return \Zicht\Itertools\reductions\add();
            case 'sub':
                return \Zicht\Itertools\reductions\sub();
            case 'mul':
                return \Zicht\Itertools\reductions\mul();
            case 'min':
                return \Zicht\Itertools\reductions\min();
            case 'max':
                return \Zicht\Itertools\reductions\max();
            case 'join':
                return \Zicht\Itertools\reductions\join();
            default:
                return $default;
        }
    }
}
