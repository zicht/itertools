<?php
/**
 * @copyright Zicht Online <https://zicht.nl>
 */

namespace Zicht\Itertools\twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Zicht\Itertools;

/**
 * Twig extension.
 */
class Extension extends AbstractExtension implements GlobalsInterface
{
    /** @var string */
    private $name;

    /**
     * @param string $name Specifies the name used, i.e. `[1, 2, 3]|it` where `it` is the name
     */
    public function __construct(string $name = 'it')
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getGlobals(): array
    {
        return [
            $this->name => (object)[
                'filters' => new Itertools\util\Filters(),
                'mappings' => new Itertools\util\Mappings(),
                'reductions' => new Itertools\util\Reductions(),
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [new TwigFilter($this->name, [$this, 'it'])];
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [new TwigFunction($this->name, [$this, 'it'])];
    }

    /**
     * Takes an iterable and returns an object that allow mapping, sorting, etc.
     *
     * @param $iterable
     * @return Itertools\lib\Interfaces\FiniteIterableInterface|Itertools\lib\IterableIterator
     */
    public function it($iterable)
    {
        return Itertools\iterable($iterable);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'zicht_itertools';
    }
}
