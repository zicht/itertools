<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait CountableTrait
{
    /**
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     */
    public function count(): ?int
    {
        if ($this instanceof \Iterator) {
            return iterator_count($this);
        }

        return null;
    }
}
