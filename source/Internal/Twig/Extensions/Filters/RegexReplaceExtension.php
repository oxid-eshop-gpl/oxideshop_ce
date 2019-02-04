<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class RegexReplaceExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 */
class RegexReplaceExtension extends AbstractExtension
{

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [new TwigFilter('regex_replace', [$this, 'regexReplace'])];
    }

    /**
     * @param string $subject
     * @param string $pattern
     * @param string $replacement
     *
     * @return string|string[]|null
     */
    public function regexReplace(string $subject, string $pattern, string $replacement)
    {
        return preg_replace($pattern, $replacement, $subject);
    }
}
