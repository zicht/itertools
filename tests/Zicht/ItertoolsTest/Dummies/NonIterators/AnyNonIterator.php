<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies\NonIterators;

use Zicht\Itertools\lib\Interfaces\AnyInterface;
use Zicht\Itertools\lib\Traits\AnyTrait;

class AnyNonIterator implements AnyInterface
{
    use AnyTrait;
}
