<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class StringIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var string */
    protected $string;

    /** @var int */
    protected $key;

    /**
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
        $this->key = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->key = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->string[$this->key];
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
        $this->key += 1;
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return $this->key < strlen($this->string);
    }
}
