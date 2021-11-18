<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\RepeatIterator;

trait RepeatTrait
{
    /**
     * Make an iterator that returns $mixed over and over again. Runs
     * indefinitely unless the $times argument is specified.
     *
     * > repeat(2)
     * 2 2 2 2 2 ...
     *
     * > repeat(10, 3)
     * 10 10 10
     *
     * @param mixed $mixed
     * @param int|null $times
     * @return RepeatIterator
     * @throws \InvalidArgumentException
     */
    public function repeat($mixed, $times = null)
    {
        if (!(is_null($times) || (is_int($times) && $times >= 0))) {
            throw new \InvalidArgumentException('Argument $times must be null or a positive integer');
        }

        return new RepeatIterator($mixed, $times);
    }
}
