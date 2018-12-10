<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\InfiniteIterableInterface;
use Zicht\Itertools\lib\Traits\InfiniteIterableTrait;

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
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->key = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->mixed;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->key += 1;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return null === $this->times ? true : $this->key < $this->times;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return null === $this->times ? -1 : $this->times;
    }
}
