<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\Traits\AllTrait;
use Zicht\Itertools\lib\Traits\AnyTrait;
use Zicht\Itertools\lib\Traits\ArrayAccessTrait;
use Zicht\Itertools\lib\Traits\ChainTrait;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\CycleTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\DifferenceTrait;
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
 * Class ChainIterator
 *
 * @package Zicht\Itertools\lib
 */
class ChainIterator extends \AppendIterator implements \Countable, \ArrayAccess
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;

    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use DifferenceTrait;
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

    /**
     * ChainIterator constructor.
     */
    public function __construct()
    {
        parent::__construct();
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \InvalidArgumentException(sprintf('Not all arguments are iterators'));
            }
            $this->append($iterable);
        }
    }

    /**
     * Extend this iterator with the contents of $iterable
     *
     * @param array|string|\Iterator $iterable
     */
    public function extend($iterable)
    {
        parent::append(conversions\mixed_to_iterator($iterable));
    }
}
