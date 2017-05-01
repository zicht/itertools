<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait LastTrait
{
    /**
     * Returns the last element of this iterable or
     * returns $default when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function last($default = null)
    {
        return iter\last($this, $default);
    }

    /**
     * Returns the key of the last element of this iterable or
     * returns $DEFAULT when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function lastKey($default = null)
    {
        $key = $default;
        foreach ($this as $key => $value) {
        }
        return $key;
    }
}
