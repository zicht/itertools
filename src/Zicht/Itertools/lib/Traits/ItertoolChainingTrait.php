<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait ItertoolChainingTrait
{
    public function accumulate($closure = 'add')
    {
        return iter\accumulate($this, $closure);
    }

    public function reduce()
    {
        return iter\reduce($this, $closure = 'add', $initializer = null);
    }

    public function chain(/* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\chain', array_merge([$this], func_get_args()));
    }

    public function cycle()
    {
        return iter\cycle($this);
    }

    public function mapBy($keyStrategy)
    {
        return iter\mapBy($keyStrategy, $this);
    }

    public function map($func /* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\map', array_merge([$func, $this], array_slice(func_get_args(), 1)));
    }
    
    public function groupby($keyStrategy, $sort = true)
    {
        return iter\groupby($keyStrategy, $this, $sort);
    }
    
    public function sorted($keyStrategy = null, $reverse = false)
    {
        return iter\sorted($keyStrategy, $this, $reverse);
    }
    
    public function filter($closure = null)
    {
        return iter\filter($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }
    
    public function filterBy($keyStrategy, $closure = null)
    {
        return iter\filterBy($keyStrategy, $closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }
    
    public function zip(/* $iterable1, $iterable2, ... */)
    {
        return call_user_func_array('\Zicht\itertools\zip', array_merge([$this], func_get_args()));
    }
    
    public function reversed()
    {
        return iter\reversed($this);
    }

    public function unique($keyStrategy = null)
    {
        return iter\unique($keyStrategy, $this);
    }

    public function any($closure = null)
    {
        return iter\any($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }

    public function all($closure = null)
    {
        return iter\all($closure === null ? function ($item) { return !empty($item); } : $closure, $this);
    }

    public function slice($start, $end = null)
    {
        return iter\slice($this, $start, $end);
    }

    public function first($default = null)
    {
        return iter\first($this, $default);
    }
}
