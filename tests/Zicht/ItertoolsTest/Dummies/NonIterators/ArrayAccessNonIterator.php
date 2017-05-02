<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies\NonIterators;


use Zicht\Itertools\lib\Traits\ArrayAccessTrait;

class ArrayAccessNonIterator implements \ArrayAccess
{
    use ArrayAccessTrait;
}
