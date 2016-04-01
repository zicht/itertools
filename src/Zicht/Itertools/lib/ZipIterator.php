<?php

namespace Zicht\Itertools\lib;

use Countable;
use InvalidArgumentException;
use MultipleIterator;

class ZipIterator extends MultipleIterator implements Countable
{
    private $key;

    public function __construct(/* \Iterator $iterable1, \Iterator $iterable2, ... */)
    {
        parent::__construct(MultipleIterator::MIT_NEED_ALL| MultipleIterator::MIT_KEYS_NUMERIC);
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new InvalidArgumentException(sprintf('Argument %d must be an iterator'));
            }
            $this->attachIterator($iterable);
        }
        $this->key = 0;
    }

    public function rewind()
    {
        parent::rewind();
        $this->key = 0;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        parent::next();
        $this->key += 1;
    }

    public function count()
    {
        return iterator_count($this);
    }

    /**
     * This method is called by var_dump() when dumping an object to get the properties that should be shown.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
     * @return array
     */
    public function __debugInfo()
    {
        return iterator_to_array($this);
    }
}
