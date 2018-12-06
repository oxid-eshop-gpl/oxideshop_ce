<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use Twig\Extension\AbstractExtension;

/**
 * Class TranslateColon
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 */
class TranslateColonExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters(): array
    {
        return [new \Twig_Filter('getTranslatedColon', [$this, 'getTranslatedColon'])];
    }

    /**
     * Adds colon for selected language
     *
     * @param string $string
     *
     * @return mixed
     */
    public function getTranslatedColon(string $string): string
    {
        $colon = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('COLON');

        return $string . $colon;
    }
}
