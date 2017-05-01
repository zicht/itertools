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
use Zicht\Itertools\lib\Traits\DifferenceTrait;
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

/**
 * Class MapIterator
 *
 * @package Zicht\Itertools\lib
 */
class MapIterator extends \MultipleIterator implements \Countable, \ArrayAccess
{
    use ArrayAccessTrait;
    use CountableTrait;
    use DebugInfoTrait;
    use GetterTrait;

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

    /** @var \Closure */
    private $valueFunc;

    /** @var \Closure */
    private $keyFunc;

    /**
     * MapIterator constructor.
     *
     * @param \Closure $valueFunc
     */
    public function __construct(\Closure $valueFunc /* [\Closure $keyFunc], \Iterator $iterable1, [\Iterator $iterable2, [...]] */)
    {
        parent::__construct(\MultipleIterator::MIT_NEED_ALL | \MultipleIterator::MIT_KEYS_NUMERIC);
        $args = func_get_args();
        $argsContainsKeyFunc = $args[1] instanceof \Closure;
        $this->valueFunc = $args[0];

        if ($argsContainsKeyFunc) {
            $this->keyFunc = $args[1];
        } else {
            $this->keyFunc = function () {
                return $this->genericKeysToKey(func_get_args());
            };
        }

        foreach (array_slice($args, $argsContainsKeyFunc ? 2 : 1) as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \InvalidArgumentException(sprintf('Not all arguments are iterators'));
            }
            $this->attachIterator($iterable);
        }
    }

    /**
     * Compute the key for an element
     *
     * When multiple iterables are given, the key for an element is computed by taking
     * the keys of the element of all iterables, when they are the same, this key is used,
     * otherwise a compound key is created by concatenating the keys together.
     *
     * @param array $keysAndValues
     * @return mixed
     */
    protected function genericKeysToKey($keysAndValues)
    {
        $keys = array_splice($keysAndValues, 0, count($keysAndValues) / 2);

        if (count($keys) == 1) {
            return $keys[0];
        }

        $value = $keys[0];
        foreach ($keys as $key) {
            if ($key !== $value) {
                // the keys are different, we will make a new string identifying this entry
                return join(
                    ':',
                    array_map(
                        function ($key) {
                            return (string)$key;
                        },
                        $keys
                    )
                );
            }
        }

        // all values are the same, use it
        return $value;
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        return call_user_func_array($this->valueFunc, array_merge(parent::current(), parent::key()));
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return call_user_func_array($this->keyFunc, array_merge(parent::key(), parent::current()));
    }

    /**
     * @{inheritDoc}
     */
    public function next()
    {
        parent::next();
    }
}
