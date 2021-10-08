<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.FunctionComment.ExtraParamComment

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
     * @param array|string|\Iterator $iterable
     * @param array|string|\Iterator $iterable2
     * @return Itertools\lib\ZipIterator
     *
     * @see Itertools\lib\Traits\ZipTrait::zip
     */
    public function zip(/* $iterable, $iterable2, ... */);
}
