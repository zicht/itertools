<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\lib\Traits;

trait InfiniteIterableTrait
{
    use AccumulateTrait;
    use FirstTrait;
    use MapByTrait;
    use MapTrait;
    use RepeatTrait;
    use SliceTrait;
    use ZipTrait;
}
