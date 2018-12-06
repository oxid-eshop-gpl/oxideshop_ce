<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\MultiLangLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class MultiLangExtension
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class MultiLangExtension extends AbstractExtension
{

    /** @var MultiLangLogic */
    private $multiLangLogic;

    /**
     * MultiLangExtension constructor.
     *
     * @param MultiLangLogic $multiLangLogic
     */
    public function __construct(MultiLangLogic $multiLangLogic)
    {
        $this->multiLangLogic = $multiLangLogic;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('multi_lang', [$this, 'multiLang'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string $ident
     * @param mixed  $arguments
     *
     * @return string
     */
    public function multiLang(string $ident, $arguments = null): string
    {
        return $this->multiLangLogic->multiLang($ident, $arguments);
    }
}
