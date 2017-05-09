<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\InfiniteIterableInterface;
use Zicht\Itertools\lib\Traits\InfiniteIterableTrait;

/**
 * Class RepeatIterator
 *
 * @package Zicht\Itertools\lib
 */
class RepeatIterator implements \Countable, InfiniteIterableInterface
{
    use InfiniteIterableTrait;

    /** @var mixed */
    private $mixed;

    /** @var integer */
    private $times;

    /** @var integer */
    private $key;

    /**
     * RepeatIterator constructor.
     *
     * @param mixed $mixed
     * @param integer $times
     */
    public function __construct($mixed, $times)
    {
        $this->mixed = $mixed;
        $this->times = $times;
        $this->key = 0;
    }

    /**
     * @{inheritDoc}
     */
    public function rewind()
    {
        $this->key = 0;
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        return $this->mixed;
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @{inheritDoc}
     */
    public function next()
    {
        $this->key += 1;
    }

    /**
     * @{inheritDoc}
     */
    public function valid()
    {
        return null === $this->times ? true : $this->key < $this->times;
    }

    /**
     * @{inheritDoc}
     */
    public function count()
    {
        return null === $this->times ? -1 : $this->times;
    }
}
