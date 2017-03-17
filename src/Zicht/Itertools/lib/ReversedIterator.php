<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class ReversedIterator
 *
 * @package Zicht\Itertools\lib
 */
class ReversedIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
     * ReversedIterator constructor.
     *
     * @param \Iterator $iterable
     */
    public function __construct(\Iterator $iterable)
    {
        $data = [];
        foreach ($iterable as $key => $value) {
            $data [] = [$key, $value];
        }
        parent::__construct(new \ArrayIterator(array_reverse($data)));
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        list($key, $value) = parent::current();
        return $key;
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        list($key, $value) = parent::current();
        return $value;
    }
}
