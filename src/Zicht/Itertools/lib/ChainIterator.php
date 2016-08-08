<?php

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\ItertoolChainingTrait;

class ChainIterator extends \AppendIterator implements \Countable, \ArrayAccess
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;
    use ItertoolChainingTrait;

    public function __construct(/* Iterator $iterable, Iterator $iterable2, ... */)
    {
        parent::__construct();
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \InvalidArgumentException(sprintf('Argument %d must be an Iterator'));
            }
            $this->append($iterable);
        }
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
