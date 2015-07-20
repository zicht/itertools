<?php

namespace iter;

use AppendIterator;
use InvalidArgumentException;
use Iterator;

class ChainIterator extends AppendIterator
{
    private $key = 0;
    
    public function __construct(/* Iterator $iterable, Iterator $iterable2, ... */)
    {
        parent::__construct();
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof Iterator) {
                throw InvalidArgumentException(sprintf('Argument %d must be an Iterator'));
            }
            $this->append($iterable);
        }
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
