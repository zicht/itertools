<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\twig;

use Zicht\Itertools as iter;

/**
 * Twig extension.
 *
 * <service id="zicht_itertools_twig_extension" class="Zicht\Itertools\twig\Extension">
 *    <tag name="twig.extension"/>
 * </service>
 *
 * @package Zicht\Itertools\twig
 */
class Extension extends \Twig_Extension
{
    /**
     * @{inheritDoc}
     */
    public function getFilters()
    {
        return array(
            // filter names are case-sensitive
            new \Twig_SimpleFilter('all', '\Zicht\Itertools\all'),
            new \Twig_SimpleFilter('any', '\Zicht\Itertools\any'),
            new \Twig_SimpleFilter('chain', '\Zicht\Itertools\chain'),
            new \Twig_SimpleFilter('filter', array($this, 'filter')),
            new \Twig_SimpleFilter('first', '\Zicht\Itertools\first'),
            new \Twig_SimpleFilter('group_by', array($this, 'groupBy')),
            new \Twig_SimpleFilter('last', '\Zicht\Itertools\last'),
            new \Twig_SimpleFilter('map', array($this, 'map')),
            new \Twig_SimpleFilter('map_by', array($this, 'mapBy')),
            new \Twig_SimpleFilter('reduce', '\Zicht\Itertools\reduce'),
            new \Twig_SimpleFilter('reversed', '\Zicht\Itertools\reversed'),
            new \Twig_SimpleFilter('sorted', array($this, 'sorted')),
            new \Twig_SimpleFilter('unique', array($this, 'unique')),
            new \Twig_SimpleFilter('zip', '\Zicht\Itertools\zip'),

            // deprecated filters
            new \Twig_SimpleFilter('filterby', array($this, 'deprecatedFilterBy')),
            new \Twig_SimpleFilter('groupBy', array($this, 'deprecatedGroupBy')),
            new \Twig_SimpleFilter('groupby', array($this, 'deprecatedGroupBy')),
            new \Twig_SimpleFilter('mapBy', array($this, 'deprecatedMapBy')),
            new \Twig_SimpleFilter('mapby', array($this, 'deprecatedMapBy')),
            new \Twig_SimpleFilter('sum', array($this, 'deprecatedSum')),
            new \Twig_SimpleFilter('uniqueby', array($this, 'deprecatedUniqueBy')),
        );
    }

    /**
     * @{inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('chain', '\Zicht\Itertools\chain'),
            new Twig_SimpleFunction('first', '\Zicht\Itertools\first'),
            new Twig_SimpleFunction('last', '\Zicht\Itertools\last'),

            // functions to create closures
            new Twig_SimpleFunction('reduction', '\Zicht\Itertools\reductions\get_reduction'),
            new Twig_SimpleFunction('mapping', '\Zicht\Itertools\mappings\get_mapping'),
        );
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @param array|string|\Iterator $iterable
     * @param mixed $strategy
     * @return iter\lib\UniqueIterator
     */
    public function unique($iterable, $strategy = null)
    {
        return iter\unique($strategy, $iterable);
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
     */
    public function reduce($iterable, $closure = 'add', $initializer = null)
    {
        return iter\reduce($iterable, $closure, $initializer);
    }

    /**
     * Make an iterator that returns consecutive groups from the
     * $iterable.  Generally, the $iterable needs to already be sorted on
     * the same key function.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return iter\lib\GroupbyIterator
     */
    public function groupBy($iterable, $strategy)
    {
        return iter\groupBy($strategy, $iterable);
    }

    /**
     * Make an iterator that returns values from $iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param array|string|\Iterator $iterable
     * @param null $strategy
     * @return iter\lib\FilterIterator
     */
    public function filter($iterable, $strategy = null)
    {
        return iter\filter($strategy, $iterable);
    }

    /**
     * Make an iterator that returns the values from $iterable sorted by
     * $strategy.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @param bool $reverse
     * @return iter\lib\SortedIterator
     */
    public function sorted($iterable, $strategy = null, $reverse = false)
    {
        return iter\sorted($strategy, $iterable, $reverse);
    }

    /**
     * Make an iterator that applies $func to every entry in the $iterables.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return iter\lib\MapIterator
     */
    public function map($iterable, $strategy)
    {
        return iter\map($strategy, $iterable);
    }

    /**
     * Make an iterator returning values from $iterable and keys from
     * $strategy.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return iter\lib\MapByIterator
     */
    public function mapBy($iterable, $strategy)
    {
        return iter\mapBy($strategy, $iterable);
    }

    /**
     * Make an iterator that returns values from $iterable where the
     * $strategy determines that the values are not empty.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return iter\lib\FilterIterator
     *
     * @deprecated Use filter instead!
     */
    public function deprecatedFilterBy($iterable, $strategy)
    {
        return iter\filterBy($strategy, $iterable);
    }


    /**
     * Make an iterator that returns consecutive groups from the
     * $iterable.  Generally, the $iterable needs to already be sorted on
     * the same key function.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return iter\lib\GroupbyIterator
     *
     * @deprecated Use group_by instead!
     */
    public function deprecatedGroupBy($iterable, $strategy)
    {
        return iter\groupBy($strategy, $iterable);
    }

    /**
     * Make an iterator returning values from $iterable and keys from
     * $strategy.
     *
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $strategy
     * @return iter\lib\MapByIterator
     *
     * @deprecated Use map_by instead!
     */
    public function deprecatedMapBy($iterable, $strategy)
    {
        return iter\mapBy($strategy, $iterable);
    }

    /**
     * Create a reduction
     *
     * @param array|string|\Iterator $iterable
     * @param int $default
     * @return int
     *
     * @deprecated Use reduce instead!
     */
    public function deprecatedSum($iterable, $default = 0)
    {
        $result = $default;
        foreach (iter\accumulate($iterable) as $result) {
        };
        return $result;
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @param array|string|\Iterator $iterable
     * @param mixed $strategy
     * @return iter\lib\UniqueIterator
     *
     * @deprecated Use unique instead!
     */
    public function deprecatedUniqueBy($iterable, $strategy = null)
    {
        return iter\unique($strategy, $iterable);
    }

    /**
     * @{inheritDoc}
     */
    function getName()
    {
        return 'zicht_itertools';
    }
}
