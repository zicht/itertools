<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

use Zicht\Itertools\lib\Traits\ToArrayTrait;

/**
 * Class BadToArrayObject
 *
 * Used to test the ToArrayTrait case where the trait is assigned to
 * an instance that is not \Traversable
 *
 */
class BadToArrayObject
{
    use ToArrayTrait;
}
