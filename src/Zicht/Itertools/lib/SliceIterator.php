<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use ArrayAccess;
use Countable;
use Iterator;
use IteratorIterator;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class SliceIterator extends IteratorIterator implements ArrayAccess, Countable
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;

    private $index;
    private $offset;
    private $length;

    public function __construct(Iterator $iterable, $offset, $length = null)
    {
        $this->index = 0;
        $this->offset = $offset;
        $this->length = $length;
        parent::__construct($iterable);
    }

    public function valid()
    {
        return $this->offset <= $this->index && (null === $this->length || $this->index < $this->length);
    }

    public function next()
    {
        $this->index += 1;
        parent::next();
    }

    public function rewind()
    {
        $this->index = 0;
        parent::rewind();
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
