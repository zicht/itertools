<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

/**
 * Class SimpleGettableObject
 *
 * @package Zicht\ItertoolsTest\Containers
 */
class SimpleGettableObject
{
    /** @var mixed */
    protected $prop;

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
     * @param $name
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
