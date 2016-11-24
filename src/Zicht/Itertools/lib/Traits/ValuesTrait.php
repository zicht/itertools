<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait ValuesTrait
{
    /**
     * Returns an array with values from this iterator
     *
     * @return array
     */
    public function values()
    {
        $values = [];
        if ($this instanceof \Traversable) {
            foreach ($this as $key => $value) {
                $values [] = $value;
            }
        }
        return $values;
    }
}
