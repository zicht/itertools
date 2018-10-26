<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

/**
 * Trait KeysTrait
 */
trait KeysTrait
{
    /**
     * Returns an array with keys from this iterator
     *
     * @return array
     */
    public function keys()
    {
        $keys = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $keys [] = $key;
            }
        }
        return $keys;
    }
}
