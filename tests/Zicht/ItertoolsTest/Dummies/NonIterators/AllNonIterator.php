<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies\NonIterators;

use Zicht\Itertools\lib\Interfaces\AllInterface;
use Zicht\Itertools\lib\Traits\AllTrait;

class AllNonIterator implements AllInterface
{
    use AllTrait;
}
