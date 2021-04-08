<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;
use Zicht\Itertools\util\Conversions;

class ChainIterator extends \AppendIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
     * @param array[]|string[]|\Iterator[] ...$iterables
     */
    public function __construct(...$iterables)
    {
        parent::__construct();
        foreach ($iterables as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \TypeError('Not all arguments are iterators');
            }
            $this->append($iterable);
        }
    }

    /**
     * Extend this iterator with the contents of $iterable
     *
     * @param array|string|\Iterator $iterable
     */
    public function extend($iterable)
    {
        parent::append(Conversions::mixedToIterator($iterable));
    }
}
