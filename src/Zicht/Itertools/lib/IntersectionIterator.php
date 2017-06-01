<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools;
use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class IntersectionIterator
 *
 * @package Zicht\Itertools\lib
 */
class IntersectionIterator extends \FilterIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $func;

    /** @var mixed[] */
    private $includes;

    /**
     * IntersectionIterator constructor.
     *
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
     * @{inheritDoc}
     */
    public function accept()
    {
        return in_array(
            call_user_func_array($this->func, [$this->current(), $this->key()]),
            $this->includes
        );
    }
}
