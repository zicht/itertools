<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class UniqueIterator extends \FilterIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $func;

    /** @var array */
    private $seen;

    public function __construct(\Closure $func, \Iterator $iterable)
    {
        $this->func = $func;
        $this->seen = [];
        parent::__construct($iterable);
    }

    /**
     * {@inheritDoc}
     */
    public function accept()
    {
        $checkValue = call_user_func($this->func, $this->current(), $this->key());
        if (in_array($checkValue, $this->seen)) {
            return false;
        }

        $this->seen [] = $checkValue;
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->seen = [];
        parent::rewind();
    }
}
