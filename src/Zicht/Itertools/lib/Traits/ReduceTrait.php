<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait ReduceTrait
{
    /**
     * @return mixed
     */
    public function reduce()
    {
        return iter\reduce($this, $closure = 'add', $initializer = null);
    }
}
