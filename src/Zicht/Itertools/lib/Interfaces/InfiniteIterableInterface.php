<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

/**
 * Interface InfiniteIterableInterface
 *
 * This interface declares everything that an infinite iterator should be able to do.
 * Note that it is a subset of the possibilities that a finite iterator has, as some
 * features require the entire iterator to be available, i.e. sorting.
 *
 */
interface InfiniteIterableInterface extends
    \Iterator,
    AccumulateInterface,
    FirstInterface,
    MapByInterface,
    MapInterface,
    SliceInterface,
    ZipInterface
{
}
