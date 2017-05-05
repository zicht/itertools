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
 * Class DifferenceIterator
 *
 * @package Zicht\Itertools\lib
 */
class DifferenceIterator extends \FilterIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $func;

    /** @var mixed[] */
    private $excludes;

    /**
     * DifferenceIterator constructor.
     *
     * @param \Iterator $iterable
     * @param \Iterator $excludesIterable
     * @param \Closure $func
     */
    public function __construct(\Iterator $iterable, \Iterator $excludesIterable, \Closure $func)
    {
        $this->func = $func;
        $this->excludes = Itertools\iterable($excludesIterable)->map($this->func)->values();
        parent::__construct($iterable);
    }

    /**
     * @{inheritDoc}
     */
    public function accept()
    {
        return !in_array(
            call_user_func_array($this->func, [$this->current(), $this->key()]),
            $this->excludes
        );
    }
}
