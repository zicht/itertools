<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\CollapseIterator;

trait CollapseTrait
{
    /**
     * Collapse a two dimentional iterator into a one dimentional iterator
     *
     * @return Itertools\lib\CollapseIterator
     */
    public function collapse()
    {
        if ($this instanceof \Iterator) {
            return new CollapseIterator($this);
        }

        return null;
    }
}
