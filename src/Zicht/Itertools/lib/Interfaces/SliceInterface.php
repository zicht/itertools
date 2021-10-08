<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\SliceTrait
 */
interface SliceInterface
{
    /**
     * TODO: document!
     *
     * @param int $start
     * @param null|int $end
     * @return Itertools\lib\SliceIterator
     *
     * @see Itertools\lib\Traits\SliceTrait::slice
     */
    public function slice($start, $end = null);
}
