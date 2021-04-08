<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;
use Zicht\Itertools\lib\SliceIterator;

/**
 * @see Itertools\lib\Traits\SliceTrait
 */
interface SliceInterface
{
    /**
     * TODO: document!
     * @see Itertools\lib\Traits\SliceTrait::slice
     */
    public function slice(int $start = 0, ?int $end = null): ?SliceIterator;
}
