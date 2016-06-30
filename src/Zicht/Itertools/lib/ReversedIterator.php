<?php

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;

class ReversedIterator extends \IteratorIterator implements \ArrayAccess, \Countable
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;

    /**
     * @param \Iterator $iterable
     */
    public function __construct(\Iterator $iterable)
    {
        $data = array();
        foreach ($iterable as $key => $value) {
            $data [] = array($key, $value);
        }
        parent::__construct(new \ArrayIterator(array_reverse($data)));
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        list($key, $value) = parent::current();
        return $key;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        list($key, $value) = parent::current();
        return $value;
    }
}
