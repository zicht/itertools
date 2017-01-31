<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

/**
 * Class DummyTraversable
 *
 * @package Zicht\ItertoolsTest\Containers
 */
class DummyTraversable implements \IteratorAggregate
{
    /** @var array */
    protected $data;

    /**
     * DummyTraversable constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return \Iterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}
