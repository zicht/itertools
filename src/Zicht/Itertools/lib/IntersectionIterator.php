<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.PropertyComment.VarTypeAvoidMixed

namespace Zicht\Itertools\lib;

use Zicht\Itertools;
use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class IntersectionIterator extends \FilterIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $func;

    /** @var mixed[] */
    private $includes;

    /**
     * @param \Iterator $iterable
     * @param \Iterator $includesIterator
     * @param \Closure $func
     */
    public function __construct(\Iterator $iterable, \Iterator $includesIterator, \Closure $func)
    {
        $this->func = $func;
        $this->includes = Itertools\iterable($includesIterator)->map($this->func)->values();
        parent::__construct($iterable);
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        return in_array(
            call_user_func_array($this->func, [$this->current(), $this->key()]),
            $this->includes
        );
    }
}
