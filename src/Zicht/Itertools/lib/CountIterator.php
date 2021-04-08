<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\InfiniteIterableInterface;
use Zicht\Itertools\lib\Traits\InfiniteIterableTrait;

class CountIterator implements InfiniteIterableInterface
{
    use InfiniteIterableTrait;

    /** @var int */
    protected $start;

    /** @var int */
    protected $step;

    /** @var int */
    protected $key;

    /**
     * @param int|float $start
     * @param int|float $step
     */
    public function __construct($start = 0, $step = 1)
    {
        if (!(is_int($start) || is_float($start))) {
            throw new \TypeError('Argument $start must be an integer or float');
        }

        if (!(is_int($step) || is_float($step))) {
            throw new \TypeError('Argument $step must be an integer or float');
        }

        $this->start = $start;
        $this->step = $step;
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
        return $this->start + ($this->key * $this->step);
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
        return true;
    }

    /**
     * This method is called by var_dump() when dumping an object to get the properties that should be shown.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
     * @return array
     */
    public function __debugInfo() // phpcs:ignore Zicht.NamingConventions.Functions.MethodNaming
    {
        $info = ['__length__' => 'infinite'];
        $count = 0;
        foreach ($this as $key => $value) {
            $info[$key] = $value;
            if ($count++ >= 4) {
                break;
            }
        }
        return $info;
    }
}
