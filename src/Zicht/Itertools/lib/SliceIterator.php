<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use Zicht\Itertools\lib\Traits\AllTrait;
use Zicht\Itertools\lib\Traits\AnyTrait;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\ChainTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\CycleTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\FilterTrait;
use Zicht\Itertools\lib\Traits\FirstTrait;
use Zicht\Itertools\lib\Traits\GroupByTrait;
use Zicht\Itertools\lib\Traits\LastTrait;
use Zicht\Itertools\lib\Traits\MapByTrait;
use Zicht\Itertools\lib\Traits\MapTrait;
use Zicht\Itertools\lib\Traits\ReduceTrait;
use Zicht\Itertools\lib\Traits\ReversedTrait;
use Zicht\Itertools\lib\Traits\SliceTrait;
use Zicht\Itertools\lib\Traits\SortedTrait;
use Zicht\Itertools\lib\Traits\ToArrayTrait;
use Zicht\Itertools\lib\Traits\UniqueTrait;
use Zicht\Itertools\lib\Traits\ZipTrait;

class SliceIterator extends \IteratorIterator implements \ArrayAccess, \Countable
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;

    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use FilterTrait;
    use FirstTrait;
    use GroupByTrait;
    use LastTrait;
    use MapByTrait;
    use MapTrait;
    use ReduceTrait;
    use ReversedTrait;
    use SliceTrait;
    use SortedTrait;
    use ToArrayTrait;
    use UniqueTrait;
    use ZipTrait;

    private $index;
    private $start;
    private $end;

    public function __construct(\Iterator $iterable, $start, $end = null)
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
}
