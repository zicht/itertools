<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

/**
 * Interface FiniteIterableInterface
 *
 * This interface declares everything that a finite iterator should be able to do.
 * Note that it is a superset of the possibilities that an infinite iterator has, as
 * some features require the entire iterator to be available, i.e. sorting.
 *
 */
interface FiniteIterableInterface extends
    \ArrayAccess,
    \Countable,
    InfiniteIterableInterface,
    AllInterface,
    AnyInterface,
    ChainInterface,
    CollapseInterface,
    CycleInterface,
    DifferenceInterface,
    FilterInterface,
    GroupByInterface,
    IntersectionInterface,
    ItemsInterface,
    KeysInterface,
    LastInterface,
    ReduceInterface,
    ReversedInterface,
    SortedInterface,
    ToArrayInterface,
    UniqueInterface,
    ValuesInterface
{
}
