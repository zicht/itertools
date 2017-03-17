<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\lib\Traits\FiniteIterableTrait;

/**
 * Class ZipIterator
 *
 * @package Zicht\Itertools\lib
 */
class ZipIterator extends \MultipleIterator implements FiniteIterableInterface
{
    use FiniteIterableTrait;

    /** @var int */
    private $key;

    /**
     * ZipIterator constructor.
     */
    public function __construct()
    {
        parent::__construct(\MultipleIterator::MIT_NEED_ALL | \MultipleIterator::MIT_KEYS_NUMERIC);
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof \Iterator) {
                throw new \InvalidArgumentException(sprintf('Not all arguments are iterators'));
            }
            $this->attachIterator($iterable);
        }
        $this->key = 0;
    }

    /**
     * @{inheritDoc}
     */
    public function rewind()
    {
        parent::rewind();
        $this->key = 0;
    }

    /**
     * @{inheritDoc}
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @{inheritDoc}
     */
    public function next()
    {
        parent::next();
        $this->key += 1;
    }
}
