<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\ItertoolsTest\twig;

use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Zicht\Itertools\lib\Interfaces\FiniteIterableInterface;
use Zicht\Itertools\twig\Extension;
use Zicht\Itertools\util\Filters;
use Zicht\Itertools\util\Mappings;
use Zicht\Itertools\util\Reductions;

class ExtensionTest extends TestCase
{
    /** @var Extension */
    protected $extension;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
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
        $this->assertEquals(['it'], array_keys($globals));
        $this->assertObjectHasAttribute('filters', $globals['it']);
        $this->assertInstanceOf(Filters::class, $globals['it']->filters);
        $this->assertObjectHasAttribute('mappings', $globals['it']);
        $this->assertInstanceOf(Mappings::class, $globals['it']->mappings);
        $this->assertObjectHasAttribute('reductions', $globals['it']);
        $this->assertInstanceOf(Reductions::class, $globals['it']->reductions);
    }

    /**
     * Ensure specific filters are available
     */
    public function testAvailableFilters()
    {
        $filters = [];

        /** @var TwigFilter $filter */
        foreach ($this->extension->getFilters() as $filter) {
            $this->assertInstanceOf(TwigFilter::class, $filter);
            $filters [] = $filter->getName();
        }

        $expected = ['it'];

        $this->assertEquals($expected, $filters);
    }

    /**
     * Ensure specific functions are available
     */
    public function testAvailableFunctions()
    {
        $functions = [];

        /** @var TwigFunction $function */
        foreach ($this->extension->getFunctions() as $function) {
            $this->assertInstanceOf(TwigFunction::class, $function);
            $functions [] = $function->getName();
        }

        $expected = ['it'];

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
     * Ensure the name of the extension is set
     */
    public function testName()
    {
        $result = $this->extension->getName();
        $this->assertEquals('zicht_itertools', $result);
    }
}
