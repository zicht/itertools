<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait ArrayAccessTrait
{
    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        foreach ($this as $key => $_) {
            if ($key === $offset) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $offset
     * @param mixed $default
     * @return mixed|null
     */
    public function offsetGet($offset, $default = null)
    {
        foreach ($this as $key => $value) {
            if ($key === $offset) {
                return $value;
            }
        }
        return $default;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('It is not possible to set iterator values');
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException('It is not possible to unset iterator values');
    }
}
