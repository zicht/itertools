<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

use Zicht\Itertools as iter;

trait FirstTrait
{
    /**
     * @param mixed $default
     * @return mixed
     */
    public function first($default = null)
    {
        return iter\first($this, $default);
    }
}
