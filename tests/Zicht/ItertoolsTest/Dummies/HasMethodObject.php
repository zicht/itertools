<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

class HasMethodObject
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
    public function hasProp()
    {
        return $this->prop;
    }
}
