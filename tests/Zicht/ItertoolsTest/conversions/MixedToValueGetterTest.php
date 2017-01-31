<?php
/**
 * @author Boudewijn Schoon <boudewijn@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\mappings;

use Zicht\Itertools\conversions;
use Zicht\ItertoolsTest\Dummies\SimpleGettableObject;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

/**
 * Class MixedToValueGetterTest
 *
 * mixed_to_value_getter MUST behave exactly like mixed_to_closure... with one exception:
 * when the input is a string, this string is evaluated to find a property path.
 *
 * @package Zicht\ItertoolsTest\mappings
 */
class MixedToValueGetterTest extends MixedToClosureTest
{
    /**
     * Test single key
     */
    public function testSingleKey()
    {
        $result = conversions\mixed_to_value_getter('key');
        $this->assertTrue(is_callable($result));

        $array = ['key' => 'foo'];
        $this->assertEquals('foo', $result($array));
    }

    /**
     * Test invalid single key
     */
    public function testInvalidSingleKey()
    {
        $result = conversions\mixed_to_value_getter('invalid');
        $this->assertTrue(is_callable($result));

        $array = ['key' => 'foo'];
        $this->assertEquals(null, $result($array));
    }

    /**
     * Test multiple keys
     */
    public function testMultipleKeys()
    {
        $result = conversions\mixed_to_value_getter('key.key');
        $this->assertTrue(is_callable($result));

        $array = ['key' => ['key' => 'foo']];
        $this->assertEquals('foo', $result($array));
    }

    /**
     * Test invalid multiple keys
     */
    public function testInvalidMultipleKeys()
    {
        $result = conversions\mixed_to_value_getter('invalid.key');
        $this->assertTrue(is_callable($result));
        $array = ['key' => ['key' => 'foo']];
        $this->assertEquals(null, $result($array));

        $result = conversions\mixed_to_value_getter('key.invalid');
        $this->assertTrue(is_callable($result));
        $array = ['key' => ['key' => 'foo']];
        $this->assertEquals(null, $result($array));
    }

    /**
     * Test single property
     */
    public function testSingleProperty()
    {
        $result = conversions\mixed_to_value_getter('prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid single property
     */
    public function testInvalidSingleProperty()
    {
        $result = conversions\mixed_to_value_getter('invalid');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test multiple properties
     */
    public function testMultipleProperties()
    {
        $result = conversions\mixed_to_value_getter('prop.prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid multiple properties
     */
    public function testInvalidMultipleProperties()
    {
        $result = conversions\mixed_to_value_getter('invalid.prop');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));

        $result = conversions\mixed_to_value_getter('prop.invalid');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test single method
     */
    public function testSingleMethod()
    {
        $result = conversions\mixed_to_value_getter('getProp');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid single method
     */
    public function testInvalidSingleMethod()
    {
        $result = conversions\mixed_to_value_getter('getInvalid');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test multiple methods
     */
    public function testMultipleMethods()
    {
        $result = conversions\mixed_to_value_getter('getProp.getProp');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid multiple methods
     */
    public function testInvalidMultipleMethods()
    {
        $result = conversions\mixed_to_value_getter('getInvalid.getProp');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));

        $result = conversions\mixed_to_value_getter('getProp.getInvalid');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test single __get
     */
    public function testSingleGetter()
    {
        $result = conversions\mixed_to_value_getter('prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleGettableObject('foo');
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid single __get
     */
    public function testInvalidSingleGetter()
    {
        $result = conversions\mixed_to_value_getter('invalid');
        $this->assertTrue(is_callable($result));

        $object = new SimpleGettableObject('foo');
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test multiple __get
     */
    public function testMultipleGetters()
    {
        $result = conversions\mixed_to_value_getter('prop.prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleGettableObject(new SimpleGettableObject('foo'));
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid multiple __get
     */
    public function testInvalidMultipleGetters()
    {
        $result = conversions\mixed_to_value_getter('invalid.prop');
        $this->assertTrue(is_callable($result));
        $object = new SimpleGettableObject(new SimpleGettableObject('foo'));
        $this->assertEquals(null, $result($object));

        $result = conversions\mixed_to_value_getter('prop.invalid');
        $this->assertTrue(is_callable($result));
        $object = new SimpleGettableObject(new SimpleGettableObject('foo'));
        $this->assertEquals(null, $result($object));
    }
}
