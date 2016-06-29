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
use Zicht\Itertools\lib\Traits\ItertoolChainingTrait;

class SliceIterator extends IteratorIterator implements ArrayAccess, Countable
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;
    use ItertoolChainingTrait;

    private $index;
    private $start;
    private $end;

    public function __construct(Iterator $iterable, $start, $end = null)
    {
        $this->index = 0;
        $this->start = $start < 0 ? iterator_count($iterable) + $start: $start;
        $this->end = $end === null ? null : ($end < 0 ? iterator_count($iterable) + $end : $end);
        parent::__construct($iterable);
    }

    public function valid()
    {
        while (parent::valid() && !($this->start <= $this->index && (null === $this->end || $this->index < $this->end))) {
            $this->next();
        }
        return parent::valid();
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
