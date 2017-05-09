<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Interfaces;

use Zicht\Itertools;

/**
 * Interface ZipInterface
 *
 * @see Itertools\lib\Traits\ZipTrait
 * @package Zicht\Itertools\lib\Interfaces
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
