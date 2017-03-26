<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

/**
 * Class GetMethodObject
 *
 * @package Zicht\ItertoolsTest\Dummies
 */
class GetMethodObject
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
    public function getProp()
    {
        return $this->prop;
    }
}
