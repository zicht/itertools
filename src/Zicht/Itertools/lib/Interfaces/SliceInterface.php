<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
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
     * @param integer $start
     * @param null|integer $end
     * @return Itertools\lib\SliceIterator
     *
     * @see Itertools\lib\Traits\SliceTrait::slice
     */
    public function slice($start, $end = null);
}
