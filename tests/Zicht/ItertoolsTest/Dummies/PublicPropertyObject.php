<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

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
