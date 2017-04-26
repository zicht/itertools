<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\Itertools\lib;

use Zicht\Itertools\lib\Traits\AllTrait;
use Zicht\Itertools\lib\Traits\AnyTrait;
use Zicht\Itertools\lib\Traits\ChainTrait;
use Zicht\Itertools\lib\Traits\CycleTrait;
use Zicht\Itertools\lib\Traits\DifferenceTrait;
use Zicht\Itertools\lib\Traits\FilterTrait;
use Zicht\Itertools\lib\Traits\FirstTrait;
use Zicht\Itertools\lib\Traits\GroupByTrait;
use Zicht\Itertools\lib\Traits\LastTrait;
use Zicht\Itertools\lib\Traits\MapByTrait;
use Zicht\Itertools\lib\Traits\MapTrait;
use Zicht\Itertools\lib\Traits\ReduceTrait;
use Zicht\Itertools\lib\Traits\ReversedTrait;
use Zicht\Itertools\lib\Traits\SliceTrait;
use Zicht\Itertools\lib\Traits\SortedTrait;
use Zicht\Itertools\lib\Traits\UniqueTrait;
use Zicht\Itertools\lib\Traits\ZipTrait;

/**
 * Class CountIterator
 *
 * @package Zicht\Itertools\lib
 */
class CountIterator implements \Iterator
{
    // Fluent interface traits
    use AllTrait;
    use AnyTrait;
    use ChainTrait;
    use CycleTrait;
    use DifferenceTrait;
    use FilterTrait;
    use FirstTrait;
    use GroupByTrait;
    use LastTrait;
    use MapByTrait;
    use MapTrait;
    use ReduceTrait;
    use ReversedTrait;
    use SliceTrait;
    use SortedTrait;
    use UniqueTrait;
    use ZipTrait;

    /** @var integer */
    protected $start;

    /** @var integer */
    protected $step;

    /** @var integer */
    protected $key;

    /**
     * CountIterator constructor.
     *
     * @param integer $start
     * @param integer $step
     */
    public function __construct($start, $step)
    {
        $this->start = $start;
        $this->step = $step;
        $this->key = 0;
    }

    /**
     * @{inheritDoc}
     */
    public function rewind()
    {
        $this->key = 0;
    }

    /**
     * @{inheritDoc}
     */
    public function current()
    {
        return $this->start + ($this->key * $this->step);
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
        $this->key += 1;
    }

    /**
     * @{inheritDoc}
     */
    public function valid()
    {
        return true;
    }

    /**
     * This method is called by var_dump() when dumping an object to get the properties that should be shown.
     *
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.debuginfo
     * @return array
     */
    public function __debugInfo()
    {
        $info = ['__length__' => 'infinite'];
        $count = 0;
        foreach ($this as $key => $value) {
            $info[$key] = $value;
            if ($count++ >= 4) {
                break;
            }
        }
        return $info;
    }
}
