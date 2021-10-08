<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

class MapIterator extends \MultipleIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var \Closure */
    private $valueFunc;

    /** @var \Closure */
    private $keyFunc;

    /**
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
     * {@inheritDoc}
     */
    public function current()
    {
        return call_user_func_array($this->valueFunc, array_merge(parent::current(), parent::key()));
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return call_user_func_array($this->keyFunc, array_merge(parent::key(), parent::current()));
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        parent::next();
    }
}
