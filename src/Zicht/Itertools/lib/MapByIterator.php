<?php

namespace Zicht\Itertools\lib;

// todo: add tests for ArrayAccess

use ArrayAccess;
use Countable;
use IteratorIterator;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\GetterTrait;
use Zicht\Itertools\lib\Traits\ItertoolChainingTrait;

/**
 * Class MapByIterator
 * @package iter
 */
class MapByIterator extends IteratorIterator implements ArrayAccess, Countable
{
    use ArrayAccessTrait;
    use DebugInfoTrait;
    use CountableTrait;
    use GetterTrait;
    use ItertoolChainingTrait;

    /**
     * @var callable
     */
    private $func;

    /**
     * @param callable $func
     * @param \Iterator $iterable
     */
    public function __construct(\Closure $func, \Iterator $iterable)
    {
        parent::__construct($iterable);
        $this->func = $func;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return call_user_func($this->func, $this->current());
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }
}
