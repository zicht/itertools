<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait GetterTrait
{
    public function first($default = null)
    {
        foreach ($this as $value) {
            return $value;
        }
        return $default;
    }

    public function has($offset)
    {
        if ($this instanceof ArrayAccessTrait) {
            return $this->offsetExists($offset);
        }
        return false;
    }

    public function get($offset, $default = null)
    {
        if ($this instanceof ArrayAccessTrait) {
            return $this->offsetGet($offset, $default);
        }
        return $default;
    }
}
