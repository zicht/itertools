<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * @see Itertools\lib\Traits\ZipTrait
 */
interface ZipInterface
{
    /**
     * Returns an iterator where one or more iterables are zipped together
     *
     * @param array|string|\Iterator $iterable2
     * @return Itertools\lib\ZipIterator
     *
     * @see Itertools\lib\Traits\ZipTrait::zip
     */
    public function zip(/* $iterable2, ... */);
}
