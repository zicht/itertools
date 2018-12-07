<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\conversions;
use Zicht\Itertools\lib\IntersectionIterator;

trait IntersectionTrait
{
    /**
     * Returns an IntersectionIterator containing elements in $this that are also in $iterable
     *
     * @param array|string|\Iterator $iterable
     * @param null|string|\Closure $strategy Optional
     * @return null|IntersectionIterator
     */
    public function intersection($iterable, $strategy = null)
    {
        if ($this instanceof \Iterator) {
            return new IntersectionIterator(
                $this,
                conversions\mixed_to_iterator($iterable),
                conversions\mixed_to_value_getter($strategy)
            );
        }

        return null;
    }
}
