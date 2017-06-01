<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

use Zicht\Itertools\lib\Interfaces\AllInterface;
use Zicht\Itertools\lib\Interfaces\AnyInterface;
use Zicht\Itertools\lib\Interfaces\ChainInterface;
use Zicht\Itertools\lib\Interfaces\CycleInterface;
use Zicht\Itertools\lib\Interfaces\DifferenceInterface;
use Zicht\Itertools\lib\Interfaces\FilterInterface;
use Zicht\Itertools\lib\Interfaces\GroupByInterface;
use Zicht\Itertools\lib\Interfaces\IntersectionInterface;
use Zicht\Itertools\lib\Interfaces\ItemsInterface;
use Zicht\Itertools\lib\Interfaces\KeysInterface;
use Zicht\Itertools\lib\Interfaces\LastInterface;
use Zicht\Itertools\lib\Interfaces\ReduceInterface;
use Zicht\Itertools\lib\Interfaces\ReversedInterface;
use Zicht\Itertools\lib\Interfaces\SortedInterface;
use Zicht\Itertools\lib\Interfaces\ToArrayInterface;
use Zicht\Itertools\lib\Interfaces\UniqueInterface;
use Zicht\Itertools\lib\Interfaces\ValuesInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class NonIterator
 *
 * This class is used to create an instance that is *not* an iterator but *does*
 * implement the itertools traits, allowing us to test the behavior of the trait
 * in this (highly unlikely to occur) situation.
 *
 * @package Zicht\ItertoolsTest\Dummies
 */
class NonIterator implements
    \ArrayAccess,
    \Countable,
    AllInterface,
    AnyInterface,
    ChainInterface,
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
    use FiniteIterableTrait;
}
