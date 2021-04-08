<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools;

trait ReduceTrait
{
    /**
     * Reduce an iterator to a single value
     *
     * > iter\iterable([1,2,3])->reduce(Reductions::add())
     * 6
     *
     * > iter\iterable([1,2,3])->reduce(Reductions::max())
     * 3
     *
     * > iter\iterable([1,2,3])->reduce(Reductions::sub(), 10)
     * 4
     *
     * > iter\iterable([])->reduce(Reductions::min(), 1)
     * 1
     *
     * @param \Closure $closure
     * @param mixed $initializer
     * @return mixed
     */
    public function reduce(\Closure $closure, $initializer = null)
    {
        if ($this instanceof \Iterator) {
            $this->rewind();

            if (null === $initializer) {
                if ($this->valid()) {
                    $initializer = $this->current();
                    $this->next();
                }
            }

            $accumulatedValue = $initializer;
            while ($this->valid()) {
                $accumulatedValue = $closure($accumulatedValue, $this->current());
                $this->next();
            }

            return $accumulatedValue;
        }

        return null;
    }
}
