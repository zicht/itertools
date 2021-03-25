<?php
/**
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace Zicht\ItertoolsTest\twig;

use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\twig\Extension;
use Zicht\Itertools\util\Filters;
use Zicht\Itertools\util\Mappings;
use Zicht\Itertools\util\Reductions;

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var Extension */
    protected $extension;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->extension = new Extension();
    }

    /**
     * Ensure specific globals are available
     */
    public function testAvailableGlobals()
    {
        $globals = $this->extension->getGlobals();
        $this->assertEquals(['itf', 'itm', 'itr'], array_keys($globals));
        $this->assertInstanceOf(Filters::class, $globals['itf']);
        $this->assertInstanceOf(Mappings::class, $globals['itm']);
        $this->assertInstanceOf(Reductions::class, $globals['itr']);
    }

    /**
     * Ensure specific filters are available
     */
    public function testAvailableFilters()
    {
        $filters = [];

        /** @var \Twig_SimpleFilter $filter */
        foreach ($this->extension->getFilters() as $filter) {
            $this->assertInstanceOf('\Twig_SimpleFilter', $filter);
            $filters [] = $filter->getName();
        }

        $expected = [
            # main filter
            'it',
            # deprecated filters (because 'it' was introduced)
            'all', 'any', 'chain', 'collapse', 'filter', 'first', 'group_by', 'last', 'map', 'map_by', 'reduce', 'reversed', 'sorted', 'unique', 'zip',
            # deprecated filters
            'filterby', 'groupBy', 'groupby', 'mapBy', 'mapby', 'sum', 'uniqueby',
        ];

        $this->assertEquals($expected, $filters);
    }

    /**
     * Ensure specific functions are available
     */
    public function testAvailableFunctions()
    {
        $functions = [];

        /** @var \Twig_SimpleFunction $function */
        foreach ($this->extension->getFunctions() as $function) {
            $this->assertInstanceOf('\Twig_SimpleFunction', $function);
            $functions [] = $function->getName();
        }

        $expected = [
            # main functions
            'chain', 'first', 'last',
            # closure functions
            'reducing', 'mapping', 'filtering',
            # deprecated functions
            'reduction',
        ];

        $this->assertEquals($expected, $functions);
    }

    /**
     * Ensure '[1, 2, 3]|it' returns an iterable
     */
    public function testIt()
    {
        $result = $this->extension->it([1, 2, 3]);
        $this->assertInstanceOf(FiniteIterableInterface::class, $result);
    }

    /**
     * Ensure unique returns a UniqueIterator
     */
    public function testUnique()
    {
        $result = $this->extension->unique([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\UniqueIterator', $result);
    }

    /**
     * Ensure reduce returns a single value
     */
    public function testReduce()
    {
        $result = $this->extension->reduce([1, 2, 3]);
        $this->assertEquals(6, $result);
    }

    /**
     * Ensure groupBy returns a GroupByIterator
     */
    public function testGroupBy()
    {
        $result = $this->extension->groupBy([1, 2, 3], null);
        $this->assertInstanceOf('Zicht\Itertools\lib\GroupbyIterator', $result);
    }

    /**
     * Ensure filter returns a FilterIterator
     */
    public function testFilter()
    {
        $result = $this->extension->filter([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\FilterIterator', $result);
    }

    /**
     * Ensure sorted returns a SortedIterator
     */
    public function testSorted()
    {
        $result = $this->extension->sorted([1, 2, 3]);
        $this->assertInstanceOf('Zicht\Itertools\lib\SortedIterator', $result);
    }

    /**
     * Ensure map returns a MapIterator
     */
    public function testMap()
    {
        $result = $this->extension->map([1, 2, 3], null);
        $this->assertInstanceOf('Zicht\Itertools\lib\MapIterator', $result);
    }

    /**
     * Ensure map returns a MapByIterator
     */
    public function testMapBy()
    {
        $result = $this->extension->mapBy([1, 2, 3], null);
        $this->assertInstanceOf('Zicht\Itertools\lib\MapByIterator', $result);
    }

    /**
     * Ensure reducing returns a closure
     */
    public function testReducing()
    {
        $result = $this->extension->reducing('add');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure reducing fails on unknown reduction
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidReducing()
    {
        $result = $this->extension->reducing('invalid');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure reducing returns a closure (deprecated)
     */
    public function testDeprecatedReduction()
    {
        $result = $this->extension->deprecatedGetReduction('add');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure reducing fails on unknown reduction (deprecated)
     *
     * @expectedException \InvalidArgumentException
     */
    public function testDeprecatedInvalidReduction()
    {
        $result = $this->extension->deprecatedGetReduction('invalid');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure mapping returns a closure
     */
    public function testMapping()
    {
        $result = $this->extension->mapping('strip');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure mapping fails on unknown map
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMapping()
    {
        $result = $this->extension->mapping('invalid');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure filtering returns a closure
     */
    public function testFiltering()
    {
        $result = $this->extension->filtering('type', 123);
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure filtering fails on unknown filter
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFiltering()
    {
        $result = $this->extension->filtering('invalid');
        $this->assertTrue(is_callable($result));
    }

    /**
     * Ensure the name of the extension is set
     */
    public function testName()
    {
        $result = $this->extension->getName();
        $this->assertEquals('zicht_itertools', $result);
    }
}
