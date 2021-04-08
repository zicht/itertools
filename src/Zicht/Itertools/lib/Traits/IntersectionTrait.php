<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\IntersectionIterator;
use Zicht\Itertools\util\Conversions;

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
                Conversions::mixedToIterator($iterable),
                Conversions::mixedToValueGetter($strategy)
            );
        }

        return null;
    }
}
