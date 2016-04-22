<?php

namespace Zicht\Itertools\lib;

class StringIterator implements \Iterator
{
    protected $string;
    protected $key;

    public function __construct($string)
    {
        $this->string = $string;
        $this->key = 0;
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function current()
    {
        return $this->string[$this->key];
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
        return $this->key < strlen($this->string);
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
            ['__length__' => iterator_count($this)],
            iterator_to_array($this)
        );
    }
}
