<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\AllTrait;
use Zicht\Itertools\lib\Traits\AnyTrait;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
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
 * Class SliceIterator
 *
 * @package Zicht\Itertools\lib
 */
class SliceIterator extends \IteratorIterator implements \ArrayAccess, \Countable
{
    use ArrayAccessTrait;
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

    /** @var integer */
    private $index;

    /** @var integer */
    private $start;

    /** @var null|int */
    private $end;

    /**
     * SliceIterator constructor.
     *
     * @param \Iterator $iterable
     * @param integer $start
     * @param null|integer $end
     */
    public function __construct(\Iterator $iterable, $start, $end = null)
    {
        if ($start < 0 || $end < 0) {
            $length = iterator_count($iterable);
        }

        $this->index = 0;
        $this->start = $start < 0 ? $length + $start : $start;
        $this->end = $end === null ? null : ($end < 0 ? $length + $end : $end);
        parent::__construct($iterable);
    }

    /**
     * @{inheritDoc}
     */
    public function valid()
    {
        while ($this->index < $this->start) {
            if (parent::valid()) {
                $this->index += 1;
                parent::next();
            } else {
                return false;
            }
        }

        if (null === $this->end || $this->index < $this->end) {
            return parent::valid();
        }

        return false;
    }

    /**
     * @{inheritDoc}
     */
    public function next()
    {
        $this->index += 1;
        parent::next();
    }

    /**
     * @{inheritDoc}
     */
    public function rewind()
    {
        $this->index = 0;
        parent::rewind();
    }
}
