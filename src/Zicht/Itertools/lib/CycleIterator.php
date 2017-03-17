<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */


namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\InfiniteIterableInterface;
use Zicht\Itertools\lib\Traits\InfiniteIterableTrait;

/**
 * Class CycleIterator
 *
 * @package Zicht\Itertools\lib
 */
class CycleIterator extends \InfiniteIterator implements InfiniteIterableInterface
{
    use InfiniteIterableTrait;
}
