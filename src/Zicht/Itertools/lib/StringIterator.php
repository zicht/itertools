<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
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
        return $this->string[$this->key];
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
        return $this->key < strlen($this->string);
    }
}
