<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class IterableIterator
 *
 * @package Zicht\Itertools\lib
 */
class IterableIterator extends \IteratorIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;
}
