<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools;

/**
 * Trait ReduceTrait
 */
trait ReduceTrait
{
    /**
     * Reduce an iterator to a single value
     *
     * > iter\iterable([1,2,3])->reduce()
     * 6
     *
     * > iter\iterable([1,2,3])->reduce('max')
     * 3
     *
     * > iter\iterable([1,2,3])->reduce('sub', 10)
     * 4
     *
     * > iter\iterable([])->reduce('min', 1)
     * 1
     *
     * @param string|\Closure $closure
     * @param mixed $initializer
     * @return mixed
     */
    public function reduce($closure = 'add', $initializer = null)
    {
        if ($this instanceof \Iterator) {
            $closure = $closure instanceof \Closure ? $closure : Itertools\reductions\get_reduction($closure);
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
