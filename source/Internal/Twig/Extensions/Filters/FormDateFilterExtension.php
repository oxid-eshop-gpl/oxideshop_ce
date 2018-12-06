<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormDateLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class FormDateFilterExtension
 */
class FormDateFilterExtension extends AbstractExtension
{

    /** @var FormDateLogic */
    private $formDateLogic;

    /**
     * FormDateFilterExtension constructor.
     *
     * @param FormDateLogic $formDateLogic
     */
    public function __construct(FormDateLogic $formDateLogic)
    {
        $this->formDateLogic = $formDateLogic;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('formdate', [$this, 'formdate'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param object $oConvObject
     * @param string $sFieldType
     * @param bool   $blPassedValue
     *
     * @return string
     */
    public function formdate($oConvObject, string $sFieldType = null, bool $blPassedValue = false): string
    {
        return $this->formDateLogic->formdate($oConvObject, $sFieldType, $blPassedValue);
    }
}
