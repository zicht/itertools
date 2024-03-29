<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

// phpcs:disable Zicht.Commenting.FunctionComment.Superfluous

namespace Zicht\ItertoolsTest\conversions;

use Zicht\Itertools\util\Conversions;
use Zicht\ItertoolsTest\Dummies\GetMethodObject;
use Zicht\ItertoolsTest\Dummies\GettableObject;
use Zicht\ItertoolsTest\Dummies\HasMethodObject;
use Zicht\ItertoolsTest\Dummies\IsMethodObject;
use Zicht\ItertoolsTest\Dummies\PublicPropertyObject;
use Zicht\ItertoolsTest\Dummies\SimpleGettableObject;
use Zicht\ItertoolsTest\Dummies\SimpleObject;

/**
 * Class MixedToValueGetterTest
 *
 * mixed_to_value_getter MUST behave exactly like mixed_to_closure... with one exception:
 * when the input is a string, this string is evaluated to find a property path.
 *
 */
class MixedToValueGetterTest extends MixedToClosureTest
{
    public function testSingleKey()
    {
        $result = Conversions::mixedToValueGetter('key');
        $this->assertTrue(is_callable($result));

        $array = ['key' => 'foo'];
        $this->assertEquals('foo', $result($array));
    }

    public function testInvalidSingleKey()
    {
        $result = Conversions::mixedToValueGetter('invalid');
        $this->assertTrue(is_callable($result));

        $array = ['key' => 'foo'];
        $this->assertEquals(null, $result($array));
    }

    public function testMultipleKeys()
    {
        $result = Conversions::mixedToValueGetter('key.key');
        $this->assertTrue(is_callable($result));

        $array = ['key' => ['key' => 'foo']];
        $this->assertEquals('foo', $result($array));
    }

    public function testInvalidMultipleKeys()
    {
        $result = Conversions::mixedToValueGetter('invalid.key');
        $this->assertTrue(is_callable($result));
        $array = ['key' => ['key' => 'foo']];
        $this->assertEquals(null, $result($array));

        $result = Conversions::mixedToValueGetter('key.invalid');
        $this->assertTrue(is_callable($result));
        $array = ['key' => ['key' => 'foo']];
        $this->assertEquals(null, $result($array));
    }

    public function testSingleProperty()
    {
        $result = Conversions::mixedToValueGetter('prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals('foo', $result($object));
    }

    public function testInvalidSingleProperty()
    {
        $result = Conversions::mixedToValueGetter('invalid');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals(null, $result($object));
    }

    public function testMultipleProperties()
    {
        $result = Conversions::mixedToValueGetter('prop.prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals('foo', $result($object));
    }

    public function testInvalidMultipleProperties()
    {
        $result = Conversions::mixedToValueGetter('invalid.prop');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));

        $result = Conversions::mixedToValueGetter('prop.invalid');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));
    }

    public function testSingleMethod()
    {
        $result = Conversions::mixedToValueGetter('getProp');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals('foo', $result($object));
    }

    public function testInvalidSingleMethod()
    {
        $result = Conversions::mixedToValueGetter('getInvalid');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject('foo');
        $this->assertEquals(null, $result($object));
    }

    public function testMultipleMethods()
    {
        $result = Conversions::mixedToValueGetter('getProp.getProp');
        $this->assertTrue(is_callable($result));

        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals('foo', $result($object));
    }

    public function testInvalidMultipleMethods()
    {
        $result = Conversions::mixedToValueGetter('getInvalid.getProp');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));

        $result = Conversions::mixedToValueGetter('getProp.getInvalid');
        $this->assertTrue(is_callable($result));
        $object = new SimpleObject(new SimpleObject('foo'));
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test single __get
     */
    public function testSingleGetter()
    {
        $result = Conversions::mixedToValueGetter('prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleGettableObject('foo');
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid single __get
     */
    public function testInvalidSingleGetter()
    {
        $result = Conversions::mixedToValueGetter('invalid');
        $this->assertTrue(is_callable($result));

        $object = new SimpleGettableObject('foo');
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test multiple __get
     */
    public function testMultipleGetters()
    {
        $result = Conversions::mixedToValueGetter('prop.prop');
        $this->assertTrue(is_callable($result));

        $object = new SimpleGettableObject(new SimpleGettableObject('foo'));
        $this->assertEquals('foo', $result($object));
    }

    /**
     * Test invalid multiple __get
     */
    public function testInvalidMultipleGetters()
    {
        $result = Conversions::mixedToValueGetter('invalid.prop');
        $this->assertTrue(is_callable($result));
        $object = new SimpleGettableObject(new SimpleGettableObject('foo'));
        $this->assertEquals(null, $result($object));

        $result = Conversions::mixedToValueGetter('prop.invalid');
        $this->assertTrue(is_callable($result));
        $object = new SimpleGettableObject(new SimpleGettableObject('foo'));
        $this->assertEquals(null, $result($object));
    }

    /**
     * Test getter strategy
     *
     * @param null|string|\Closure $strategy
     * @param mixed $object
     * @param mixed $expect
     * @dataProvider testGetterStrategyProvider
     */
    public function testGetters($strategy, $object, $expect)
    {
        $result = Conversions::mixedToValueGetter($strategy);
        $this->assertTrue(is_callable($result));
        $this->assertEquals($expect, $result($object));
    }

    public function testGetterStrategyProvider(): array
    {
        return [
            // find key in array
            ['key', ['key' => 'foo'], 'foo'],
            ['invalid', ['key' => 'foo'], null],
            ['key.key', ['key' => ['key' => 'foo']], 'foo'],
            ['key.invalid', ['key' => ['key' => 'foo']], null],
            ['invalid.key', ['key' => ['key' => 'foo']], null],

            // find public property in object
            ['prop', new PublicPropertyObject('foo'), 'foo'],
            ['invalid', new PublicPropertyObject('foo'), null],
            ['prop.prop', new PublicPropertyObject(new PublicPropertyObject('foo')), 'foo'],
            ['prop.invalid', new PublicPropertyObject(new PublicPropertyObject('foo')), null],
            ['invalid.prop', new PublicPropertyObject(new PublicPropertyObject('foo')), null],

            // find getProp in object (explicit prefixing 'get')
            ['getProp', new GetMethodObject('foo'), 'foo'],
            ['getInvalid', new GetMethodObject('foo'), null],
            ['getProp.getProp', new GetMethodObject(new GetMethodObject('foo')), 'foo'],
            ['getProp.invalid', new GetMethodObject(new GetMethodObject('foo')), null],
            ['invalid.getProp', new GetMethodObject(new GetMethodObject('foo')), null],

            // find getProp in object (implicit prefixing 'get')
            ['prop', new GetMethodObject('foo'), 'foo'],
            ['invalid', new GetMethodObject('foo'), null],
            ['prop.prop', new GetMethodObject(new GetMethodObject('foo')), 'foo'],
            ['prop.invalid', new GetMethodObject(new GetMethodObject('foo')), null],
            ['invalid.prop', new GetMethodObject(new GetMethodObject('foo')), null],

            // find isProp (implicit prefixing 'is')
            ['prop', new IsMethodObject('foo'), 'foo'],
            ['invalid', new IsMethodObject('foo'), null],
            ['prop.prop', new IsMethodObject(new IsMethodObject('foo')), 'foo'],
            ['prop.invalid', new IsMethodObject(new IsMethodObject('foo')), null],
            ['invalid.prop', new IsMethodObject(new IsMethodObject('foo')), null],

            // find hasProp (implicit prefixing 'has')
            ['prop', new HasMethodObject('foo'), 'foo'],
            ['invalid', new HasMethodObject('foo'), null],
            ['prop.prop', new HasMethodObject(new HasMethodObject('foo')), 'foo'],
            ['prop.invalid', new HasMethodObject(new HasMethodObject('foo')), null],
            ['invalid.prop', new HasMethodObject(new HasMethodObject('foo')), null],

            // find __get (implicit call to __get('prop')
            ['prop', new GettableObject('foo'), 'foo'],
            ['invalid', new GettableObject('foo'), null],
            ['prop.prop', new GettableObject(new GettableObject('foo')), 'foo'],
            ['prop.invalid', new GettableObject(new GettableObject('foo')), null],
            ['invalid.prop', new GettableObject(new GettableObject('foo')), null],
        ];
    }
}
