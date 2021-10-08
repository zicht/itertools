<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.PropertyComment.VarTypeAvoidMixed

namespace Zicht\ItertoolsTest\Dummies;

class SimpleGettableObject
{
    /** @var mixed */
    protected $prop;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->prop = $value;
    }

    /**
     * Get a value
     *
     * @param mixed $name
     * @return mixed|null
     */
    public function __get($name)
    {
        switch ($name) {
            case 'prop':
                return $this->prop;

            default:
                return null;
        }
    }
}
