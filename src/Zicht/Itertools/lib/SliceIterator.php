<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class SliceIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var int */
    private $index;

    /** @var int */
    private $start;

    /** @var null|int */
    private $end;

    /**
     * @param \Iterator $iterable
     * @param int $start
     * @param null|int $end
     */
    public function __construct(\Iterator $iterable, $start, $end = null)
    {
        if ($start < 0 || $end < 0) {
            $length = iterator_count($iterable);
        } else {
            // length is not needed.  still, we will define it for code cleanliness
            $length = 0;
        }

        $this->index = 0;
        $this->start = $start < 0 ? $length + $start : $start;
        $this->end = $end === null ? null : ($end < 0 ? $length + $end : $end);
        parent::__construct($iterable);
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        while ($this->index < $this->start) {
            if (parent::valid()) {
                $this->index += 1;
                parent::next();
            } else {
                return false;
            }
        }

        if (null === $this->end || $this->index < $this->end) {
            return parent::valid();
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->index += 1;
        parent::next();
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->index = 0;
        parent::rewind();
    }
}
