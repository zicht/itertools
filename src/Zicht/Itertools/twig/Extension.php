<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\twig;

use Closure;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
use Zicht\Itertools as iter;

/**
 * Twig extension.
 *
 * <service id="zicht_itertools_twig_extension" class="Zicht\Itertools\twig\Extension">
 *    <tag name="twig.extension"/>
 * </service>
 *
 * Class Extension
 * @package Zicht\Itertools\twig
 */
class Extension extends Twig_Extension
{
    /**
     * @{inheritDoc}
     */
    public function getFilters()
    {
        return array(
            // filter names are case-sensitive
            new Twig_SimpleFilter('all', '\Zicht\Itertools\all'),
            new Twig_SimpleFilter('any', '\Zicht\Itertools\any'),
            new Twig_SimpleFilter('chain', '\Zicht\Itertools\chain'),
            new Twig_SimpleFilter('filter', '\Zicht\Itertools\filter'),
            new Twig_SimpleFilter('first', '\Zicht\Itertools\first'),
            new Twig_SimpleFilter('groupBy', array($this, 'groupBy')),
            new Twig_SimpleFilter('last', '\Zicht\Itertools\last'),
            new Twig_SimpleFilter('map', array($this, 'map')),
            new Twig_SimpleFilter('mapBy', array($this, 'mapBy')),
            new Twig_SimpleFilter('reduce', '\Zicht\Itertools\reduce'),
            new Twig_SimpleFilter('sorted', array($this, 'sorted')),
            new Twig_SimpleFilter('unique', array($this, 'unique')),
            new Twig_SimpleFilter('zip', '\Zicht\Itertools\zip'),

            // deprecated filters
            new Twig_SimpleFilter('filterby', array($this, 'filterBy')),
            new Twig_SimpleFilter('groupby', array($this, 'groupByLowercase')),
            new Twig_SimpleFilter('mapby', array($this, 'mapByLowercase')),
            new Twig_SimpleFilter('sum', array($this, 'sum')),
            new Twig_SimpleFilter('uniqueby', array($this, 'uniqueBy')),
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
            new Twig_SimpleFunction('reduction', '\Zicht\Itertools\util\Reductions::getReduction'),
            new Twig_SimpleFunction('mapping', '\Zicht\Itertools\util\Mappings::getMapping'),
        );
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @param array|string|\Iterator $iterable
     * @param mixed $keyStrategy
     * @return iter\lib\UniqueIterator
     */
    public function unique($items, $keyStrategy = null)
    {
        return iter\unique($keyStrategy, $items);
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @deprecated use unique($iterable, $keyStrategy) instead
     * @param array|string|\Iterator $iterable
     * @param mixed $keyStrategy
     * @return iter\lib\UniqueIterator
     */
    public function uniqueBy($items, $keyStrategy)
    {
        return iter\unique($keyStrategy, $items);
    }

    /**
     * @deprecated Use reduce instead!
     * @param $iterable
     * @param int $default
     * @return int
     */
    public function sum($iterable, $default = 0)
    {
        $result = $default;
        foreach (iter\accumulate($iterable) as $result) {};
        return $result;
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
     */
    public function reduce($iterable, $operation = 'sum', $default = 0)
    {
        return iter\reduce($iterable, $operation, $default);
    }

    /**
     * Make an iterator that returns consecutive groups from the
     * $iterable.  Generally, the $iterable needs to already be sorted on
     * the same key function.
     *
     * @see \Zicht\Itertools\groupby
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @return iter\lib\GroupbyIterator
     */
    public function groupBy($iterable, $keyStrategy)
    {
        return iter\groupBy($keyStrategy, $iterable);
    }

    /**
     * Make an iterator that returns consecutive groups from the
     * $iterable.  Generally, the $iterable needs to already be sorted on
     * the same key function.
     *
     * @deprecated Use groupBy instead! (upper-case B)
     * @see \Zicht\Itertools\groupby
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @return iter\lib\GroupbyIterator
     */
    public function groupByLowercase($iterable, $keyStrategy)
    {
        return iter\groupBy($keyStrategy, $iterable);
    }

    /**
     * Make an iterator that returns the values from $iterable sorted by
     * $keyStrategy.
     *
     * @see \Zicht\Itertools\sorted
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @param bool $reverse
     * @return iter\lib\SortedIterator
     */
    public function sorted($iterable, $keyStrategy = null, $reverse = false)
    {
        return iter\sorted($keyStrategy, $iterable, $reverse);
    }

    /**
     * Make an iterator that applies $func to every entry in the $iterables.
     *
     * @see \Zicht\Itertools\map
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @return iter\lib\MapIterator
     */
    public function map($iterable, $keyStrategy)
    {
        return iter\map($keyStrategy, $iterable);
    }

    /**
     * Make an iterator returning values from $iterable and keys from
     * $keyStrategy.
     *
     * @see \Zicht\Itertools\mapby
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @return iter\lib\MapByIterator
     */
    public function mapBy($iterable, $keyStrategy)
    {
        return iter\mapBy($keyStrategy, $iterable);
    }

    /**
     * Make an iterator returning values from $iterable and keys from
     * $keyStrategy.
     *
     * @deprecated Use mapBy instead! (upper-case B)
     * @see \Zicht\Itertools\mapby
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @return iter\lib\MapByIterator
     */
    public function mapByLowercase($iterable, $keyStrategy)
    {
        return iter\mapBy($keyStrategy, $iterable);
    }

    /**
     * @see \Zicht\Itertools\filterby
     * @param array|string|\Iterator $iterable
     * @param string|\Closure $keyStrategy
     * @return iter\lib\FilterIterator
     */
    public function filterBy($iterable, $keyStrategy)
    {
        return iter\filterBy($keyStrategy, $iterable);
    }

    /**
     * @{inheritDoc}
     */
    function getName()
    {
        return 'zicht_itertools';
    }
}
