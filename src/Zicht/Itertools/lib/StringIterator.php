<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

/**
 * Class StringIterator
 *
 * @package Zicht\Itertools\lib
 */
class StringIterator implements \Iterator, \Countable
{
    use CountableTrait;
    use DebugInfoTrait;

    /** @var string */
    protected $string;

    /** @var int */
    protected $key;

    /**
     * StringIterator constructor.
     *
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
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
        return $this->string[$this->key];
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
        return $this->key < strlen($this->string);
    }
}
