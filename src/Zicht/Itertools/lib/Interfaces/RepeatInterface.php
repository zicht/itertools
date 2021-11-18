<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;
use Zicht\Itertools\lib\RepeatIterator;

/**
 * @see Itertools\lib\Traits\RepeatTrait
 */
interface RepeatInterface
{
    /**
     * Make an iterator that returns $mixed over and over again. Runs
     * indefinitely unless the $times argument is specified.
     *
     * @param mixed $mixed
     * @param int|null $times
     * @return RepeatIterator
     * @throws \InvalidArgumentException
     *
     * @see Itertools\lib\Traits\RepeatTrait::repeat
     */
    public function repeat($mixed, $times = null);
}
