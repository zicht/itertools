<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\InfiniteIterableInterface;
use Zicht\Itertools\lib\Traits\InfiniteIterableTrait;

class CountIterator implements InfiniteIterableInterface
{
    use InfiniteIterableTrait;

    /** @var integer */
    protected $start;

    /** @var integer */
    protected $step;

    /** @var integer */
    protected $key;

    /**
     * @param integer $start
     * @param integer $step
     */
    public function __construct($start, $step)
    {
        $this->start = $start;
        $this->step = $step;
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
        return $this->start + ($this->key * $this->step);
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
