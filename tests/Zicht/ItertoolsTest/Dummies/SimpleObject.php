<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.PropertyComment.VarTypeAvoidMixed

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
