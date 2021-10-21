<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\CollapseIterator;

trait CollapseTrait
{
    /**
     * Collapse a two dimensional iterator into a one dimensional iterator
     */
    public function collapse(): ?CollapseIterator
    {
        if ($this instanceof \Iterator) {
            return new CollapseIterator($this);
        }

        return null;
    }
}
