<?php

namespace Zicht\Itertools\lib;

// todo: add tests

use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\ItertoolChainingTrait;

class FilterIterator extends \FilterIterator implements \Countable
{
    use CountableTrait;
    use DebugInfoTrait;
    use ItertoolChainingTrait;

    private $func;

    function __construct(\Closure $func,\ Iterator $iterable)
    {
        $this->func = $func;
        parent::__construct($iterable);
    }

    public function accept()
    {
        return call_user_func($this->func, $this->current());
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
