<?php

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\AllTrait;
use Zicht\Itertools\lib\Traits\AnyTrait;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\ChainTrait;
use Zicht\Itertools\lib\Traits\CycleTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\FilterTrait;
use Zicht\Itertools\lib\Traits\FirstTrait;
use Zicht\Itertools\lib\Traits\GetterTrait;
use Zicht\Itertools\lib\Traits\GroupByTrait;
use Zicht\Itertools\lib\Traits\ItemsTrait;
use Zicht\Itertools\lib\Traits\KeysTrait;
use Zicht\Itertools\lib\Traits\LastTrait;
use Zicht\Itertools\lib\Traits\MapByTrait;
use Zicht\Itertools\lib\Traits\MapTrait;
use Zicht\Itertools\lib\Traits\ReduceTrait;
use Zicht\Itertools\lib\Traits\ReversedTrait;
use Zicht\Itertools\lib\Traits\SliceTrait;
use Zicht\Itertools\lib\Traits\SortedTrait;
use Zicht\Itertools\lib\Traits\ToArrayTrait;
use Zicht\Itertools\lib\Traits\UniqueTrait;
use Zicht\Itertools\lib\Traits\ValuesTrait;
use Zicht\Itertools\lib\Traits\ZipTrait;

// todo: add unit tests for Countable interface
// todo: add unit tests for ArrayAccess interface
// todo: place the two classed in their own file

class GroupedIterator extends \IteratorIterator implements \Countable, \ArrayAccess
{
    use ArrayAccessTrait;
    use DebugInfoTrait;
    use GetterTrait;

    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use FilterTrait;
    use FirstTrait;
    use GroupByTrait;
    use ItemsTrait;
    use KeysTrait;
    use LastTrait;
    use MapByTrait;
    use MapTrait;
    use ReduceTrait;
    use ReversedTrait;
    use SliceTrait;
    use SortedTrait;
    use ToArrayTrait;
    use UniqueTrait;
    use ValuesTrait;
    use ZipTrait;

    protected $groupKey;
    protected $values;

    public function __construct($groupKey)
    {
        $this->groupKey = $groupKey;
        parent::__construct(new \ArrayIterator());
    }

    public function getGroupKey()
    {
        return $this->groupKey;
    }

    public function append($key, $value)
    {
        $this->getInnerIterator()->append(array($key, $value));
    }

    public function current()
    {
        return $this->getInnerIterator()->current()[1];
    }

    public function key()
    {
        return $this->getInnerIterator()->current()[0];
    }

    public function count()
    {
        return iterator_count($this->getInnerIterator());
    }
}

class GroupbyIterator extends \IteratorIterator implements \Countable, \ArrayAccess
{
    use ArrayAccessTrait;
    use DebugInfoTrait;

    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use FilterTrait;
    use FirstTrait;
    use GroupByTrait;
    use ItemsTrait;
    use KeysTrait;
    use LastTrait;
    use MapByTrait;
    use MapTrait;
    use ReduceTrait;
    use ReversedTrait;
    use SliceTrait;
    use SortedTrait;
    use ToArrayTrait;
    use UniqueTrait;
    use ValuesTrait;
    use ZipTrait;

    public function __construct(\Closure $func, \Iterator $iterable)
    {
        // todo: this implementation pre-computes everything... this is
        // not the way an iterator should work.  Please re-write.
        $groupedIterator = null;
        $previousGroupKey = null;
        $data = array();

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

    public function key()
    {
        return $this->current()->getGroupKey();
    }

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
}
