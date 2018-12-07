<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\TranslateLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class TranslateExtension
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class TranslateExtension extends AbstractExtension
{

    /** @var TranslateLogic */
    private $translateLogic;

    /**
     * TranslateExtension constructor.
     *
     * @param TranslateLogic $translateLogic
     */
    public function __construct(TranslateLogic $translateLogic)
    {
        $this->translateLogic = $translateLogic;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('translate', [$this, 'translate'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string $ident
     * @param mixed  $arguments
     *
     * @return string
     */
    public function translate($ident, $arguments = null): string
    {
        return $this->translateLogic->translate($ident, $arguments);
    }
}
