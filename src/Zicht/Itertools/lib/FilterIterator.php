<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class FilterIterator
 *
 * @package Zicht\Itertools\lib
 */
class FilterIterator extends \FilterIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $func;

    /**
     * FilterIterator constructor.
     *
     * @param \Closure $func
     * @param \Iterator $iterable
     */
    public function __construct(\Closure $func, \Iterator $iterable)
    {
        $this->func = $func;
        parent::__construct($iterable);
    }

    /**
     * @{inheritDoc}
     */
    public function accept()
    {
        return call_user_func_array($this->func, [$this->current(), $this->key()]);
    }
}
