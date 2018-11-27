<?php

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\TruncateLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class TruncateExtension
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class TruncateExtension extends AbstractExtension
{

    /** @var TruncateLogic */
    private $truncateLogic;

    /**
     * TruncateExtension constructor.
     *
     * @param TruncateLogic $truncateLogic
     */
    public function __construct(TruncateLogic $truncateLogic)
    {
        $this->truncateLogic = $truncateLogic;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string  $string
     * @param integer $length
     * @param string  $suffix
     * @param bool    $breakWords
     * @param bool    $middle
     *
     * @return string
     */
    public function truncate($string, $length = 80, $suffix = '...', $breakWords = false, $middle = false): string
    {
        return $this->truncateLogic->truncate($string, $length, $suffix, $breakWords, $middle);
    }
}
