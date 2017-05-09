<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class MapByIterator
 *
 * @package Zicht\Itertools\lib
 */
class MapByIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
     * @var callable
     */
    private $func;

    /**
     * MapByIterator constructor.
     *
     * @param \Closure $func
     * @param \Iterator $iterable
     */
    public function __construct(\Closure $func, \Iterator $iterable)
    {
        parent::__construct($iterable);
        $this->func = $func;
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return call_user_func($this->func, $this->current(), parent::key());
    }
}
