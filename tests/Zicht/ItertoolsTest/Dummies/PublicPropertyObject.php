<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.PropertyComment.VarTypeAvoidMixed

namespace Zicht\ItertoolsTest\Dummies;

class PublicPropertyObject
{
    /** @var mixed */
    public $prop;

    /**
     * SimpleObject constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->prop = $value;
    }
}
