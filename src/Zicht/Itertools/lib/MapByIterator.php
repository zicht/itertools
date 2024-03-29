<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class MapByIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
     * @var callable
     */
    private $func;

    public function __construct(\Closure $func, \Iterator $iterable)
    {
        parent::__construct($iterable);
        $this->func = $func;
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return call_user_func($this->func, $this->current(), parent::key());
    }
}
