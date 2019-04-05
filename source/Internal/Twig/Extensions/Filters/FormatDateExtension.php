<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatDateLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class FormatDateExtension
 */
class FormatDateExtension extends AbstractExtension
{

    /** @var FormatDateLogic */
    private $formatDateLogic;

    /**
     * FormatDateExtension constructor.
     *
     * @param FormatDateLogic $formatDateLogic
     */
    public function __construct(FormatDateLogic $formatDateLogic)
    {
        $this->formatDateLogic = $formatDateLogic;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('date_format', [$this, 'formatDate'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param object $convObject
     * @param string $fieldType
     * @param bool   $passedValue
     *
     * @return string
     */
    public function formatDate($convObject, string $fieldType = null, bool $passedValue = false): string
    {
        return $this->formatDateLogic->formdate($convObject, $fieldType, $passedValue);
    }
}
