<?php

namespace Zicht\Itertools\lib;

use Closure;
use Countable;
use InvalidArgumentException;
use Iterator;
use MultipleIterator;

class MapIterator extends MultipleIterator implements Countable
{
    private $valueFunc;
    private $keyFunc;

    public function __construct(Closure $valueFunc /* [Closure $keyFunc], \Iterator $iterable1, [\Iterator $iterable2, [...]] */)
    {
        parent::__construct(MultipleIterator::MIT_NEED_ALL| MultipleIterator::MIT_KEYS_NUMERIC);
        $args = func_get_args();
        $argsContainsKeyFunc = $args[1] instanceof Closure;
        $this->valueFunc = $args[0];
        $this->keyFunc = $argsContainsKeyFunc ? $args[1] : function () { return $this->genericKeysToKey(func_get_args()); };
        foreach (array_slice($args, $argsContainsKeyFunc ? 2 : 1) as $iterable) {
            if (!$iterable instanceof Iterator) {
                throw new InvalidArgumentException(sprintf('Argument %d must be an iterator'));
            }
            $this->attachIterator($iterable);
        }
    }

    protected function genericKeysToKey($keys)
    {
        if (count($keys) == 1) {
            return $keys[0];
        }

        $value = $keys[0];
        foreach ($keys as $key) {
            if ($key !== $value) {
                // the keys are different, we will make a new string identifying this entry
                return join(':', array_map(function ($key) { return (string)$key; }, $keys));
            }
        }

        // all values are the same, use it
        return $value;
    }

    public function current()
    {
        return call_user_func_array($this->valueFunc, parent::current());
    }

    public function key()
    {
        return call_user_func_array($this->keyFunc, parent::key());
    }

    public function next()
    {
        parent::next();
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return iterator_count($this);
    }
}
