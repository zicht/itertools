<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait GetterTrait
{
    /**
     * Returns true when a key exists of the same type and value as $OFFSET
     *
     * @param mixed $offset
     * @return bool
     */
    public function has($offset)
    {
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $_) {
                if ($key === $offset) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns the value of a key with the same type and value as $OFFSET, or returns
     * $DEFAULT when it this key does not exist
     *
     * @param mixed $offset
     * @param mixed $default
     * @return mixed
     */
    public function get($offset, $default = null)
    {
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                if ($key === $offset) {
                    return $value;
                }
            }
        }
        return $default;
    }
}
