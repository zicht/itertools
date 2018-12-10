<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

// todo: place the two classed in their own file
// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

class GroupedIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var mixed */
    protected $groupKey;

    /**
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
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->getInnerIterator()->current()[1];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->getInnerIterator()->current()[0];
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }
}

class GroupbyIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /**
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
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->current()->getGroupKey();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }
}
