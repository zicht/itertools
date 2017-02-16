<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\AllTrait;
use Zicht\Itertools\lib\Traits\AnyTrait;
use Zicht\Itertools\lib\Traits\ChainTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\CycleTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\FilterTrait;
use Zicht\Itertools\lib\Traits\FirstTrait;
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

/**
 * Class AccumulateIterator
 *
 * @package Zicht\Itertools\lib
 */
class AccumulateIterator implements \Iterator, \Countable
{
    use CountableTrait;
    use DebugInfoTrait;

    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use FilterTrait;
    use FirstTrait;
    use GroupByTrait;
    use LastTrait;
    use MapByTrait;
    use MapTrait;
    use ReduceTrait;
    use ReversedTrait;
    use SliceTrait;
    use SortedTrait;
    use UniqueTrait;
    use ZipTrait;

    protected $iterable;
    protected $func;
    protected $value;

    /**
     * AccumulateIterator constructor.
     *
     * @param \Iterator $iterable
     * @param \Closure $func
     */
    public function __construct(\Iterator $iterable, \Closure $func)
    {
        $this->iterable = $iterable;
        $this->func = $func;
        $this->value = null;
    }

    /**
     * @{inheritDoc}
     */
    public function rewind()
    {
        $this->iterable->rewind();
        $this->value = $this->iterable->valid() ? $this->iterable->current() : null;
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        return $this->value;
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return $this->iterable->key();
    }

    /**
     * @{inheritDoc}
     */
    public function next()
    {
        $this->iterable->next();
        if ($this->iterable->valid()) {
            // must assign $this->func to $func before calling the closure
            // because otherwise it will try fo find a method called func,
            // which doesn't exist
            $func = $this->func;
            $this->value = $func($this->value, $this->iterable->current());
        }
    }

    /**
     * @{inheritDoc}
     */
    public function valid()
    {
        return $this->iterable->valid();
    }
}
