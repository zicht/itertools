<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

class DummyTraversable implements \IteratorAggregate
{
    /** @var array */
    protected $data;

    /**
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
