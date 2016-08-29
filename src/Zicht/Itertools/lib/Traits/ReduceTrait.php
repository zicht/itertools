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
    public function reduce($closure = 'add', $initializer = null)
    {
        return iter\reduce($this, $closure, $initializer);
    }
}
