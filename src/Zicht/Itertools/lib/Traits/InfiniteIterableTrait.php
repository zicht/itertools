<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

/**
 * Trait InfiniteIterableTrait
 */
trait InfiniteIterableTrait
{
    use AccumulateTrait;
    use FirstTrait;
    use MapByTrait;
    use MapTrait;
    use SliceTrait;
    use ZipTrait;
}
