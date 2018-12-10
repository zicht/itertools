<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait FirstTrait
{
    /**
     * Returns the first element of this iterable or
     * returns $default when this iterable is empty
     *
     * @param mixed $default
     * @return mixed
     */
    public function first($default = null)
    {
        if ($this instanceof \Iterator) {
            $item = $default;
            foreach ($this as $item) {
                break;
            }
            return $item;
        }

        return null;
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
        if ($this instanceof \Iterator) {
            $key = $default;
            foreach ($this as $key => $value) {
                break;
            }
            return $key;
        }

        return null;
    }
}
