<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

class SimpleObject
{
    /** @var mixed */
    public $prop;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->prop = $value;
    }

    /**
     * @return mixed
     */
    public function getProp()
    {
        return $this->prop;
    }
}
