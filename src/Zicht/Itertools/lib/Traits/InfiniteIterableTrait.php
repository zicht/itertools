<?php
/**
 * @copyright Zicht Online <https://www.zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait InfiniteIterableTrait
{
    use AccumulateTrait;
    use FirstTrait;
    use MapByTrait;
    use MapTrait;
    use SliceTrait;
    use ZipTrait;
}
