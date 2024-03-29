<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class FilterIterator extends \FilterIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $func;

    public function __construct(\Closure $func, \Iterator $iterable)
    {
        $this->func = $func;
        parent::__construct($iterable);
    }

    /**
     * {@inheritDoc}
     */
    public function accept()
    {
        return call_user_func_array($this->func, [$this->current(), $this->key()]);
    }
}
