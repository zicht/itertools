<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\Dummies;

/**
 * Class PublicPropertyObject
 *
 * @package Zicht\ItertoolsTest\Dummies
 */
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
