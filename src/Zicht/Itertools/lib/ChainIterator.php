<?php

namespace Zicht\Itertools\lib;

use AppendIterator;
use Countable;
use InvalidArgumentException;
use Iterator;

class ChainIterator extends AppendIterator implements Countable
{
    private $count = 0;

    public function __construct(/* Iterator $iterable, Iterator $iterable2, ... */)
    {
        parent::__construct();
        foreach (func_get_args() as $iterable) {
            if (!$iterable instanceof Iterator) {
                throw new InvalidArgumentException(sprintf('Argument %d must be an Iterator'));
            }
            $this->count += iterator_count($iterable);
            $this->append($iterable);
        }
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * This method is called by var_dump() when dumping an object to get the properties that should be shown.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
     * @return array
     */
    public function __debugInfo()
    {
        return array_merge(
            ['__length__' => iterator_count($this)],
            iterator_to_array($this)
        );
    }
}
