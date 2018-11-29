<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\WordWrapLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class WordWrapExtension
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class WordWrapExtension extends AbstractExtension
{

    /** @var WordWrapLogic */
    private $wordWrapLogic;

    /**
     * WordWrapExtension constructor.
     *
     * @param WordWrapLogic $wordWrapLogic
     */
    public function __construct(WordWrapLogic $wordWrapLogic)
    {
        $this->wordWrapLogic = $wordWrapLogic;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('word_wrap', [$this, 'wordWrap'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string  $string
     * @param integer $length
     * @param string  $wrapper
     * @param bool    $cut
     *
     * @return string
     */
    public function wordWrap($string, $length = 80, $wrapper = "\n", $cut = false): string
    {
        return $this->wordWrapLogic->wordWrap($string, $length, $wrapper, $cut);
    }
}
