<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
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
 * @package Zicht\ItertoolsTest\Dummies
 */
class BadToArrayObject
{
    use ToArrayTrait;
}
