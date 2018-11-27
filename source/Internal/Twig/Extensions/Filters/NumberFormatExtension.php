<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\NumberFormatLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class NumberFormatExtension
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class NumberFormatExtension extends AbstractExtension
{

    /** @var NumberFormatLogic */
    private $numberFormatLogic;

    /**
     * NumberFormatLogic constructor.
     *
     * @param NumberFormatLogic $numberFormatLogic
     */
    public function __construct(NumberFormatLogic $numberFormatLogic)
    {
        $this->numberFormatLogic = $numberFormatLogic;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('number_format', [$this, 'numberFormat'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string     $format
     * @param string|int $value
     *
     * @return string
     */
    public function numberFormat($format, $value): string
    {
        return $this->numberFormatLogic->numberFormat($format, $value);
    }
}
