<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Closure;
use Iterator;
use Zicht\Itertools as iter;

trait ItertoolChainingTrait
{
    /**
     * @param string|Closure $closure
     * @return iter\lib\AccumulateIterator
     */
    public function accumulate($closure = 'add')
    {
        return iter\accumulate($this, $closure);
    }

    /**
     * @return mixed
     */
    public function reduce()
    {
        return iter\reduce($this, $closure = 'add', $initializer = null);
    }

    /**
     * @param array|string|Iterator $iterable1
     * @param array|string|Iterator $iterable2
     * @param array|string|Iterator $iterableN
     * @return iter\lib\ChainIterator
     */
    public function chain(/* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\chain', array_merge([$this], func_get_args()));
    }

    /**
     * @return iter\lib\CycleIterator
     */
    public function cycle()
    {
        return iter\cycle($this);
    }

    /**
     * @param string|Closure $keyStrategy
     * @return iter\lib\KeyCallbackIterator
     */
    public function mapBy($keyStrategy)
    {
        return iter\mapBy($keyStrategy, $this);
    }

    /**
     * @param Closure|callable $func
     * @param array|string|Iterator $iterable1
     * @param array|string|Iterator $iterable2
     * @param array|string|Iterator $iterableN
     * @return iter\lib\MapIterator
     */
    public function map($func /* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\map', array_merge([$func, $this], array_slice(func_get_args(), 1)));
    }

    /**
     * @param string|Closure $keyStrategy
     * @param bool $sort
     * @return iter\lib\GroupbyIterator
     */
    public function groupby($keyStrategy, $sort = true)
    {
        return iter\groupby($keyStrategy, $this, $sort);
    }

    /**
     * @param string|Closure $keyStrategy
     * @param bool $reverse
     * @return iter\lib\SortedIterator
     */
    public function sorted($keyStrategy = null, $reverse = false)
    {
        return iter\sorted($keyStrategy, $this, $reverse);
    }

    /**
     * @param Closure $closure Optional, when not specified !empty will be used
     * @return iter\lib\FilterIterator
     */
    public function filter($closure = null)
    {
        return iter\filter($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }

    /**
     * @param string|Closure $keyStrategy
     * @param Closure $closure Optional, when not specified !empty will be used
     * @return iter\lib\FilterIterator
     */
    public function filterBy($keyStrategy, $closure = null)
    {
        return iter\filterBy($keyStrategy, $closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }

    /**
     * @param array|string|Iterator $iterable1
     * @param array|string|Iterator $iterable2
     * @param array|string|Iterator $iterableN
     * @return iter\lib\ZipIterator
     */
    public function zip(/* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\zip', array_merge([$this], func_get_args()));
    }

    /**
     * @return iter\lib\ReversedIterator
     */
    public function reversed()
    {
        return iter\reversed($this);
    }

    /**
     * @param string|Closure $keyStrategy
     * @return iter\lib\UniqueIterator
     */
    public function unique($keyStrategy = null)
    {
        return iter\unique($keyStrategy, $this);
    }

    /**
     * @param Closure $closure Optional, when not specified !empty will be used
     * @return bool
     */
    public function any($closure = null)
    {
        return iter\any($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }

    /**
     * @param Closure $closure Optional, when not specified !empty will be used
     * @return bool
     */
    public function all($closure = null)
    {
        return iter\all($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }

    /**
     * @param integer $start
     * @param null|integer $end
     * @return iter\lib\SliceIterator
     */
    public function slice($start, $end = null)
    {
        return iter\slice($this, $start, $end);
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function first($default = null)
    {
        return iter\first($this, $default);
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public function last($default = null)
    {
        return iter\last($this, $default);
    }
}
