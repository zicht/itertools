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
    public function offsetGet($offset, $default = null)
    {
        switch ($offset) {
            case 0:
            case 'key':
                return $this->key;

            case 1:
            case 'value':
                return $this->value;

            default:
                throw new \InvalidArgumentException('$OFFSET must be either 0, 1, "key", or "value"');
        }
    }

    /**
     * @{inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        switch ($offset) {
            case 0:
            case 'key':
                $this->key = $value;
                break;

            case 1:
            case 'value':
                $this->value = $value;
                break;

            default:
                throw new \InvalidArgumentException('$OFFSET must be either 0, 1, "key", or "value"');
        }
    }

    /**
     * @{inheritDoc}
     */
    public function offsetUnset($offset)
    {
        return $this->offsetSet($offset, null);
    }
}
