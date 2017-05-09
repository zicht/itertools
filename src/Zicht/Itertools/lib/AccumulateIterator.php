<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class AccumulateIterator
 *
 * @package Zicht\Itertools\lib
 */
class AccumulateIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Iterator */
    protected $iterable;

    /** @var \Closure */
    protected $func;

    /** @var mixed */
    protected $value;

    /**
     * AccumulateIterator constructor.
     *
     * @param \Iterator $iterable
     * @param \Closure $func
     */
    public function __construct(\Iterator $iterable, \Closure $func)
    {
        $this->iterable = $iterable;
        $this->func = $func;
        $this->value = null;
    }

    /**
     * @{inheritDoc}
     */
    public function rewind()
    {
        $this->iterable->rewind();
        $this->value = $this->iterable->valid() ? $this->iterable->current() : null;
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        return $this->value;
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return $this->iterable->key();
    }

    /**
     * @{inheritDoc}
     */
    public function next()
    {
        $this->iterable->next();
        if ($this->iterable->valid()) {
            // must assign $this->func to $func before calling the closure
            // because otherwise it will try fo find a method called func,
            // which doesn't exist
            $func = $this->func;
            $this->value = $func($this->value, $this->iterable->current());
        }
    }

    /**
     * @{inheritDoc}
     */
    public function valid()
    {
        return $this->iterable->valid();
    }
}
