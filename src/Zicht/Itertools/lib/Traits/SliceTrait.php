<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools\lib\SliceIterator;

trait SliceTrait
{
    /**
     * TODO: document!
     *
     * @param integer $start
     * @param null|integer $end
     * @return SliceIterator
     */
    public function slice($start, $end = null)
    {
        if (!is_int($start)) {
            throw new \InvalidArgumentException('Argument $start must be an integer');
        }

        if (!(is_null($end) || is_int($end))) {
            throw new \InvalidArgumentException('Argument $end must be an integer or null');
        }

        if ($this instanceof \Iterator) {
            return new SliceIterator($this, $start, $end);
        }

        return null;
    }
}
