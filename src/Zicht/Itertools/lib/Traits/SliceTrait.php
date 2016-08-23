<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait SliceTrait
{
    /**
     * @param integer $start
     * @param null|integer $end
     * @return iter\lib\SliceIterator
     */
    public function slice($start, $end = null)
    {
        return iter\slice($this, $start, $end);
    }
}
