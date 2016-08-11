<?php

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\ItertoolChainingTrait;

class CountIterator implements \Iterator
{
    use ItertoolChainingTrait;

    protected $start;
    protected $step;
    protected $key;

    public function __construct($start, $step)
    {
        $this->start = $start;
        $this->step = $step;
        $this->key = 0;
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function current()
    {
        return $this->start + ($this->key * $this->step);
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        $this->key += 1;
    }

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
    public function __debugInfo()
    {
        return array_merge(
            ['__length__' => 'infinite'],
            iterator_to_array($this)
        );
    }
}
