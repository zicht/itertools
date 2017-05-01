<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait FirstTrait
{
    /**
     * Returns the first element of this iterable or
     * returns $DEFAULT when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function first($default = null)
    {
        return iter\first($this, $default);
    }

    /**
     * Returns the key of the first element of this iterable or
     * returns $DEFAULT when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function firstKey($default = null)
    {
        $key = $default;
        foreach ($this as $key => $value) {
            break;
        }
        return $key;
    }
}
