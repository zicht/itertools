<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Containers;

/**
 * Class Pair
 *
 * @package Zicht\Itertools\lib\Containers
 */
class KeyValuePair implements \ArrayAccess
{
    /** @var mixed */
    public $key;

    /** @var mixed */
    public $value;

    /**
     * Pair constructor.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __construct($key = null, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @{inheritDoc}
     */
    public function offsetExists($offset)
    {
        return in_array($offset, [0, 1, 'key', 'value']);
    }

    /**
     * @{inheritDoc}
     */
    public function offsetGet($offset)
    {
        if ($offset === 0 || $offset === 'key') {
            return $this->key;
        }

        if ($offset === 1 || $offset === 'value') {
            return $this->value;
        }

        throw new \InvalidArgumentException('$OFFSET must be either 0, 1, "key", or "value"');
    }

    /**
     * @{inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === 0 || $offset === 'key') {
            $this->key = $value;
        }

        if ($offset === 1 || $offset === 'value') {
            $this->value = $value;
        }

        throw new \InvalidArgumentException('$OFFSET must be either 0, 1, "key", or "value"');
    }

    /**
     * @{inheritDoc}
     */
    public function offsetUnset($offset)
    {
        return $this->offsetSet($offset, null);
    }
}
