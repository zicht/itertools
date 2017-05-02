<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies\NonIterators;

use Zicht\Itertools\lib\Interfaces\AccumulateInterface;
use Zicht\Itertools\lib\Traits\AccumulateTrait;

class AccumulateNonIterator implements AccumulateInterface
{
    use AccumulateTrait;
}
