<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\twig;

use Twig\Extension\GlobalsInterface;
use Zicht\Itertools;

/**
 * Twig extension.
 */
class Extension extends \Twig_Extension implements GlobalsInterface
{
    /**
     * {@inheritDoc}
     */
    public function getGlobals()
    {
        return [
            'itf' => new Itertools\util\Filters(),
            'itm' => new Itertools\util\Mappings(),
            'itr' => new Itertools\util\Reductions(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('it', [$this, 'it']),

            // deprecated filters (because 'it' was introduced)
            new \Twig_SimpleFilter('all', '\Zicht\Itertools\all', ['deprecated' => true, 'alternative' => '|it.all']),
            new \Twig_SimpleFilter('any', '\Zicht\Itertools\any', ['deprecated' => true, 'alternative' => '|it.any']),
            new \Twig_SimpleFilter('chain', '\Zicht\Itertools\chain', ['deprecated' => true, 'alternative' => '|it.chain']),
            new \Twig_SimpleFilter('collapse', '\Zicht\Itertools\collapse', ['deprecated' => true, 'alternative' => '|it.collapse']),
            new \Twig_SimpleFilter('filter', [$this, 'filter'], ['deprecated' => true, 'alternative' => '|it.filter']),
            new \Twig_SimpleFilter('first', '\Zicht\Itertools\first', ['deprecated' => true, 'alternative' => '|it.first']),
            new \Twig_SimpleFilter('group_by', [$this, 'groupBy'], ['deprecated' => true, 'alternative' => '|it.groupBy']),
            new \Twig_SimpleFilter('last', '\Zicht\Itertools\last', ['deprecated' => true, 'alternative' => '|it.last']),
            new \Twig_SimpleFilter('map', [$this, 'map'], ['deprecated' => true, 'alternative' => '|it.map']),
            new \Twig_SimpleFilter('map_by', [$this, 'mapBy'], ['deprecated' => true, 'alternative' => '|it.mapBy']),
            new \Twig_SimpleFilter('reduce', '\Zicht\Itertools\reduce', ['deprecated' => true, 'alternative' => '|it.reduce']),
            new \Twig_SimpleFilter('reversed', '\Zicht\Itertools\reversed', ['deprecated' => true, 'alternative' => '|it.reversed']),
            new \Twig_SimpleFilter('sorted', [$this, 'sorted'], ['deprecated' => true, 'alternative' => '|it.sorted']),
            new \Twig_SimpleFilter('unique', [$this, 'unique'], ['deprecated' => true, 'alternative' => '|it.unique']),
            new \Twig_SimpleFilter('zip', '\Zicht\Itertools\zip', ['deprecated' => true, 'alternative' => '|it.zip']),

            // deprecated filters
            new \Twig_SimpleFilter('filterby', [$this, 'deprecatedFilterBy'], ['deprecated' => true, 'alternative' => '|it.filter']),
            new \Twig_SimpleFilter('groupBy', [$this, 'deprecatedGroupBy'], ['deprecated' => true, 'alternative' => '|it.groupBy']),
            new \Twig_SimpleFilter('groupby', [$this, 'deprecatedGroupBy'], ['deprecated' => true, 'alternative' => '|it.groupBy']),
            new \Twig_SimpleFilter('mapBy', [$this, 'deprecatedMapBy'], ['deprecated' => true, 'alternative' => '|it.mapBy']),
            new \Twig_SimpleFilter('mapby', [$this, 'deprecatedMapBy'], ['deprecated' => true, 'alternative' => '|it.mapBy']),
            new \Twig_SimpleFilter('sum', [$this, 'deprecatedSum'], ['deprecated' => true, 'alternative' => '|it.reduce']),
            new \Twig_SimpleFilter('uniqueby', [$this, 'deprecatedUniqueBy'], ['deprecated' => true, 'alternative' => '|it.unique']),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            // deprecated functions (because 'it' was introduced)
            new \Twig_SimpleFunction('chain', '\Zicht\Itertools\chain', ['deprecated' => true, 'alternative' => '|it.chain']),
            new \Twig_SimpleFunction('first', '\Zicht\Itertools\first', ['deprecated' => true, 'alternative' => '|it.first']),
            new \Twig_SimpleFunction('last', '\Zicht\Itertools\last', ['deprecated' => true, 'alternative' => '|it.last']),

            // deprecated functions (because 'itr', 'itm', and 'itf' were introduced)
            new \Twig_SimpleFunction('reducing', [$this, 'reducing'], ['deprecated' => true, 'alternative' => 'itr']),
            new \Twig_SimpleFunction('mapping', [$this, 'mapping'], ['deprecated' => true, 'alternative' => 'itm']),
            new \Twig_SimpleFunction('filtering', [$this, 'filtering'], ['deprecated' => true, 'alternative' => 'itf']),

            // deprecated functions
            new \Twig_SimpleFunction('reduction', [$this, 'deprecatedGetReduction'], ['deprecated' => true, 'alternative' => 'reducing']),
        ];
    }

    /**
     * Takes an iterable and returns an object that allow mapping, sorting, etc.
     *
     * @param $iterable
     * @return Itertools\lib\Interfaces\FiniteIterableInterface|Itertools\lib\IterableIterator
     */
    public function it($iterable)
    {
        return Itertools\iterable($iterable);
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @param array|string|\Iterator $iterable
     * @param mixed $strategy
     * @return Itertools\lib\UniqueIterator
     * @deprecated
     */
    public function unique($iterable, $strategy = null)
    {
        return Itertools\unique($strategy, $iterable);
    }

    /**
     * Reduce an iterable to a single value
     *
     * Simple examples:
     * {{ [1,2,3]|reduce }} --> 6
     * {{ [1,2,3]|reduce('max') }} --> 3
     *
     * Sro example to get the prices for all items in the basket:
     * {{ transaction_snapshot.Basket.Items|map('TotalPrice.Amount')|reduce }}
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $closure
     * @param mixed $initializer
     * @return mixed
     * @deprecated
     */
    public function reduce($iterable, $closure = 'add', $initializer = null)
    {
        return Itertools\reduce($iterable, $closure, $initializer);
    }

    /**
     * Make an iterator that returns consecutive groups from the
     * $iterable.  Generally, the $iterable needs to already be sorted on
     * the same key function.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @param boolean $sort
     * @return Itertools\lib\GroupbyIterator
     * @deprecated
     */
    public function groupBy($iterable, $strategy, $sort = true)
    {
        return Itertools\group_by($strategy, $iterable, $sort);
    }

    /**
     * Make an iterator that returns values from $iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param array|string|\Iterator $iterable
     * @param null $strategy
     * @return Itertools\lib\FilterIterator
     * @deprecated
     */
    public function filter($iterable, $strategy = null)
    {
        return Itertools\filter($strategy, $iterable);
    }

    /**
     * Make an iterator that returns the values from $iterable sorted by
     * $strategy.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @param bool $reverse
     * @return Itertools\lib\SortedIterator
     * @deprecated
     */
    public function sorted($iterable, $strategy = null, $reverse = false)
    {
        return Itertools\sorted($strategy, $iterable, $reverse);
    }

    /**
     * Make an iterator that applies $func to every entry in the $iterables.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return Itertools\lib\MapIterator
     * @deprecated
     */
    public function map($iterable, $strategy)
    {
        return Itertools\map($strategy, $iterable);
    }

    /**
     * Make an iterator returning values from $iterable and keys from
     * $strategy.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return Itertools\lib\MapByIterator
     * @deprecated
     */
    public function mapBy($iterable, $strategy)
    {
        return Itertools\map_by($strategy, $iterable);
    }


    /**
     * Returns a reduction closure
     *
     * Any parameters provided, beyond $name, are passed directly to the underlying
     * reduction.  This can be used to, for example, provide a $glue when using join.
     *
     * @param string $name
     * @return \Closure
     * @throws \InvalidArgumentException
     */
    public function reducing($name)
    {
        // note, once we stop supporting php 5.5, we can rewrite the code below
        // to the reducing($name, ...$args) structure.
        // http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list
        $method = sprintf('\Zicht\Itertools\util\Reductions::%s', $name);
        if (!is_callable($method)) {
            throw new \InvalidArgumentException(sprintf('$name "%s" is not a valid reduction.', $name));
        }
        return call_user_func_array($method, array_slice(func_get_args(), 1));
    }

    /**
     * Returns a mapping closure
     *
     * Any parameters provided, beyond $name, are passed directly to the underlying
     * mapping.  This can be used to, for example, provide a $glue when using join.
     *
     * @param string $name
     * @return \Closure
     * @throws \InvalidArgumentException
     */
    public function mapping($name)
    {
        // note, once we stop supporting php 5.5, we can rewrite the code below
        // to the reducing($name, ...$args) structure.
        // http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list
        $method = sprintf('\Zicht\Itertools\util\Mappings::%s', $name);
        if (!is_callable($method)) {
            throw new \InvalidArgumentException(sprintf('$name "%s" is not a valid mapping.', $name));
        }
        return call_user_func_array($method, array_slice(func_get_args(), 1));
    }

    /**
     * Returns a filter closure
     *
     * Any parameters provided, beyond $name, are passed directly to the underlying
     * filter.  This can be used to, for example, provide a $glue when using join.
     *
     * @param string $name
     * @return \Closure
     * @throws \InvalidArgumentException
     */
    public function filtering($name)
    {
        // note, once we stop supporting php 5.5, we can rewrite the code below
        // to the reducing($name, ...$args) structure.
        // http://php.net/manual/en/functions.arguments.php#functions.variable-arg-list
        $method = sprintf('\Zicht\Itertools\util\Filters::%s', $name);
        if (!is_callable($method)) {
            throw new \InvalidArgumentException(sprintf('$name "%s" is not a valid filter.', $name));
        }
        return call_user_func_array($method, array_slice(func_get_args(), 1));
    }

    /**
     * Make an iterator that returns values from $iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return Itertools\lib\FilterIterator
     * @deprecated Use filter instead!
     */
    public function deprecatedFilterBy($iterable, $strategy)
    {
        return Itertools\filter($strategy, $iterable);
    }

    /**
     * Make an iterator that returns consecutive groups from the
     * $iterable.  Generally, the $iterable needs to already be sorted on
     * the same key function.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return Itertools\lib\GroupbyIterator
     * @deprecated Use group_by instead!
     */
    public function deprecatedGroupBy($iterable, $strategy)
    {
        return Itertools\group_by($strategy, $iterable);
    }

    /**
     * Make an iterator returning values from $iterable and keys from
     * $strategy.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return Itertools\lib\MapByIterator
     * @deprecated Use map_by instead!
     */
    public function deprecatedMapBy($iterable, $strategy)
    {
        return Itertools\mapBy($strategy, $iterable);
    }

    /**
     * Create a reduction
     *
     * @param array|string|\Iterator $iterable
     * @param int $default
     * @return int
     * @deprecated Use reduce instead!
     */
    public function deprecatedSum($iterable, $default = 0)
    {
        $result = $default;
        foreach (Itertools\accumulate($iterable) as $result) {
        };
        return $result;
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @param array|string|\Iterator $iterable
     * @param mixed $strategy
     * @return Itertools\lib\UniqueIterator
     * @deprecated Use unique instead!
     */
    public function deprecatedUniqueBy($iterable, $strategy = null)
    {
        return Itertools\unique($strategy, $iterable);
    }

    /**
     * Returns a reduction closure
     *
     * @param string $name
     * @return \Closure
     * @throws \InvalidArgumentException
     * @deprecated Use reducing instead!
     */
    public function deprecatedGetReduction($name)
    {
        return call_user_func_array([$this, 'reducing'], func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'zicht_itertools';
    }
}
