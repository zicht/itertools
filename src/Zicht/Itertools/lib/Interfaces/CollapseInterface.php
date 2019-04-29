<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\CollapseTrait
 */
interface CollapseInterface
{
    /**
     * Collapse a two dimentional iterator into a one dimentional iterator
     *
     * @return Itertools\lib\CollapseIterator
     *
     * @see Itertools\lib\Traits\CollapseTrait::collapse
     */
    public function collapse();
}
