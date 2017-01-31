<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

/**
 * Class simpleObject
 *
 * @package Zicht\ItertoolsTest
 */
class SimpleObject
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

    /**
     * @return mixed
     */
    public function getProp()
    {
        return $this->prop;
    }
}
