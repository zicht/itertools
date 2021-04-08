<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class ZipIterator extends \MultipleIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var int */
    private $key;

    /**
     * @param array[]|string[]|\Iterator[] ...$iterables
     */
    public function __construct(...$iterables)
    {
        parent::__construct(\MultipleIterator::MIT_NEED_ALL | \MultipleIterator::MIT_KEYS_NUMERIC);
        foreach ($iterables as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \TypeError(sprintf('Not all arguments are iterators'));
            }
            $this->attachIterator($iterable);
        }
        $this->key = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        parent::rewind();
        $this->key = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        parent::next();
        $this->key += 1;
    }
}
