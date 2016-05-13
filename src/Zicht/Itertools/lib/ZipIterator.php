<?php

namespace Zicht\Itertools\lib;

use Countable;
use InvalidArgumentException;
use MultipleIterator;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class ZipIterator extends MultipleIterator implements Countable
{
    use CountableTrait;
    use DebugInfoTrait;

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
}
