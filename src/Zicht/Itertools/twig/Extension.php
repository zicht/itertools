<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\twig;

use Iterator;
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
     * @inheritDoc
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('all', '\Zicht\Itertools\all'),
            new Twig_SimpleFilter('any', '\Zicht\Itertools\any'),
            new Twig_SimpleFilter('chain', '\Zicht\Itertools\chain'),
            new Twig_SimpleFilter('filter', '\Zicht\Itertools\filter'),
            new Twig_SimpleFilter('first', '\Zicht\Itertools\first'),
            new Twig_SimpleFilter('groupby', array($this, 'groupby')),
            new Twig_SimpleFilter('last', '\Zicht\Itertools\last'),
            new Twig_SimpleFilter('map', array($this, 'map')),
            new Twig_SimpleFilter('mapby', array($this, 'mapby')),
            new Twig_SimpleFilter('reduce', '\Zicht\Itertools\reduce'),
            new Twig_SimpleFilter('sorted', array($this, 'sorted')),
            new Twig_SimpleFilter('unique', array($this, 'unique')),
            new Twig_SimpleFilter('zip', '\Zicht\Itertools\zip'),

            // deprecated filters
            new Twig_SimpleFilter('filterby', array($this, 'filterby')),
            new Twig_SimpleFilter('sum', array($this, 'sum')),
            new Twig_SimpleFilter('uniqueby', array($this, 'uniqueby')),
        );
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('chain', '\Zicht\Itertools\chain'),
            new Twig_SimpleFunction('first', '\Zicht\Itertools\first'),
            new Twig_SimpleFunction('last', '\Zicht\Itertools\last'),
        );
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @param array|string|Iterator $iterable
     * @param mixed $keyStrategy
     * @return array
     */
    public function unique($items, $keyStrategy = null)
    {
        return iter\unique($keyStrategy, $items);
    }

    /**
     * Takes an iterable and returns another iterable that is unique.
     *
     * @deprecated use unique($iterable, $keyStrategy) instead
     * @param array|string|Iterator $iterable
     * @param mixed $keyStrategy
     * @return array
     */
    public function uniqueby($items, $keyStrategy)
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

    public function groupby($iterable, $keyStrategy)
    {
        return iter\groupby($keyStrategy, $iterable);
    }

    public function sorted($iterable, $keyStrategy = null, $reverse = false)
    {
        return iter\sorted($keyStrategy, $iterable, $reverse);
    }

    public function map($iterable, $keyStrategy)
    {
        return iter\map($keyStrategy, $iterable);
    }

    public function mapby($iterable, $keyStrategy)
    {
        return iter\mapBy($keyStrategy, $iterable);
    }

    public function filterby($iterable, $keyStrategy)
    {
        return iter\filterBy($keyStrategy, $iterable);
    }

    function getName()
    {
        return 'zicht_itertools';
    }
}