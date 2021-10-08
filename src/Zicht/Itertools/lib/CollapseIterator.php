<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class CollapseIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
     * @param \Iterator $iterable
     */
    public function __construct(\Iterator $iterable)
    {
        $data = [];
        foreach ($iterable as $subIterable) {
            if (is_array($subIterable) || $subIterable instanceof \Traversable) {
                foreach ($subIterable as $key => $value) {
                    $data [] = [$key, $value];
                }
            }
        }
        parent::__construct(new \ArrayIterator($data));
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        list($key, $value) = parent::current();
        return $key;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        list($key, $value) = parent::current();
        return $value;
    }
}
