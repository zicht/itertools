<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */


namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\InfiniteIterableInterface;
use Zicht\Itertools\lib\Traits\InfiniteIterableTrait;

class CycleIterator extends \InfiniteIterator implements InfiniteIterableInterface
{
    use InfiniteIterableTrait;
}
