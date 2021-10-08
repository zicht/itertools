<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.PropertyComment.VarTypeAvoidMixed

namespace Zicht\ItertoolsTest\Dummies;

class IsMethodObject
{
    /** @var mixed */
    private $prop;

    /**
     * SimpleObject constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->prop = $value;
    }

    /**
     * Get a value
     *
     * @return mixed|null
     */
    public function isProp()
    {
        return $this->prop;
    }
}
