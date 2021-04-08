<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\SliceIterator;

trait SliceTrait
{
    /**
     * TODO: document!
     */
    public function slice(int $start = 0, ?int $end = null): ?SliceIterator
    {
        if (!is_int($start)) {
            throw new \TypeError('Argument $start must be an integer');
        }

        if (!(is_null($end) || is_int($end))) {
            throw new \TypeError('Argument $end must be an integer or null');
        }

        if ($this instanceof \Iterator) {
            return new SliceIterator($this, $start, $end);
        }

        return null;
    }
}
