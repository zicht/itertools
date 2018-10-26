<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

/**
 * Trait ArrayAccessTrait
 */
trait ArrayAccessTrait
{
    /**
     * Returns true when a key exists of the same type and value as $OFFSET
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
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
    public function offsetGet($offset, $default = null)
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

    /**
     * Not implemented
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('It is not possible to set iterator values');
    }

    /**
     * Not implemented
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException('It is not possible to unset iterator values');
    }
}
