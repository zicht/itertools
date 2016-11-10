<?php

namespace Zicht\Itertools\lib;

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

class UniqueIterator extends \FilterIterator implements \Countable, \ArrayAccess
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

    private $func;
    private $seen;

    function __construct(\Closure $func, \Iterator $iterable)
    {
        $this->func = $func;
        $this->seen = array();
        parent::__construct($iterable);
    }

    public function accept()
    {
        $checkValue = call_user_func($this->func, $this->current(), $this->key());
        if (in_array($checkValue, $this->seen)) {
            return false;
        } else {
            $this->seen [] = $checkValue;
            return true;
        }
    }

    public function rewind()
    {
        $this->seen = array();
        parent::rewind();
    }
}
