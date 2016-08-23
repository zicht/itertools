<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait LastTrait
{
    /**
     * @param mixed $default
     * @return mixed
     */
    public function last($default = null)
    {
        return iter\last($this, $default);
    }
}
