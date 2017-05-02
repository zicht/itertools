<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies\NonIterators;

use Zicht\Itertools\lib\Interfaces\ChainInterface;
use Zicht\Itertools\lib\Traits\ChainTrait;

class ChainNonIterator implements ChainInterface
{
    use ChainTrait;
}
