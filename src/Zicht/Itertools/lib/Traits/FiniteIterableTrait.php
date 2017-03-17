<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait FiniteIterableTrait
{
    use InfiniteIterableTrait;

    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;
    use GetterTrait;

    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use FilterTrait;
    use GroupByTrait;
    use ItemsTrait;
    use KeysTrait;
    use LastTrait;
    use ReduceTrait;
    use ReversedTrait;
    use SortedTrait;
    use ToArrayTrait;
    use UniqueTrait;
    use ValuesTrait;
}
