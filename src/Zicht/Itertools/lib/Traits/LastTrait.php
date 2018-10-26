<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

/**
 * Trait LastTrait
 */
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
        if ($this instanceof \Iterator) {
            $item = $default;
            foreach ($this as $item) {
            }
            return $item;
        }

        return null;
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
        if ($this instanceof \Iterator) {
            $key = $default;
            foreach ($this as $key => $value) {
            }
            return $key;
        }

        return null;
    }
}
