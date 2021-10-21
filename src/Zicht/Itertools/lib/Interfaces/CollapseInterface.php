<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;
use Zicht\Itertools\lib\CollapseIterator;

/**
 * @see Itertools\lib\Traits\CollapseTrait
 */
interface CollapseInterface
{
    /**
     * Collapse a two dimentional iterator into a one dimentional iterator
     *
     * @see Itertools\lib\Traits\CollapseTrait::collapse
     */
    public function collapse(): ?CollapseIterator;
}
