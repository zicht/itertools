<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class ChainIterator extends \AppendIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    public function __construct()
    {
        parent::__construct();
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \InvalidArgumentException(sprintf('Not all arguments are iterators'));
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
        parent::append(conversions\mixed_to_iterator($iterable));
    }
}
