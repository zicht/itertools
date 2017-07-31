<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

// todo: place the two classed in their own file

/**
 * Class GroupedIterator
 *
 * @package Zicht\Itertools\lib
 */
class GroupedIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var mixed */
    protected $groupKey;

    /**
     * GroupedIterator constructor.
     *
     * @param mixed $groupKey
     */
    public function __construct($groupKey)
    {
        $this->groupKey = $groupKey;
        parent::__construct(new \ArrayIterator());
    }

    /**
     * @return mixed
     */
    public function getGroupKey()
    {
        return $this->groupKey;
    }

    /**
     * Adds an element to the iterable
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function append($key, $value)
    {
        $this->getInnerIterator()->append([$key, $value]);
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        return $this->getInnerIterator()->current()[1];
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return $this->getInnerIterator()->current()[0];
    }

    /**
     * @{inheritDoc}
     */
    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }
}

/**
 * Class GroupbyIterator
 *
 * @package Zicht\Itertools\lib
 */
class GroupbyIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
     * GroupbyIterator constructor.
     *
     * @param \Closure $func
     * @param \Iterator $iterable
     */
    public function __construct(\Closure $func, \Iterator $iterable)
    {
        // todo: this implementation pre-computes everything... this is
        // not the way an iterator should work.  Please re-write.
        $groupedIterator = null;
        $previousGroupKey = null;
        $data = [];

        foreach ($iterable as $key => $value) {
            $groupKey = call_user_func($func, $value, $key);
            if ($previousGroupKey !== $groupKey || $groupedIterator === null) {
                $previousGroupKey = $groupKey;
                $groupedIterator = new GroupedIterator($groupKey);
                $data [] = $groupedIterator;
            }
            $groupedIterator->append($key, $value);
        }

        parent::__construct(new \ArrayIterator($data));
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return $this->current()->getGroupKey();
    }

    /**
     * @{inheritDoc}
     */
    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }

    /**
     * @{inheritDoc}
     */
    public function toArray()
    {
        $array = iterator_to_array($this);
        array_walk(
            $array,
            function (&$value) {
                /** @var GroupedIterator $value */
                $value = $value->toArray();
            }
        );
        return $array;
    }

    /**
     * @{inheritDoc}
     */
    public function values()
    {
        $values = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $values [] = $value->values();
            }
        }
        return $values;
    }
}
