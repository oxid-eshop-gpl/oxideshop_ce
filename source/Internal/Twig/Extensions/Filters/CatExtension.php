<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use Twig\Extension\AbstractExtension;

/**
 * Class CatExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Filters
 */
class CatExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('cat', [$this, 'cat'])];
    }

    /**
     * @param string $string
     * @param string $cat
     *
     * @return string
     */
    public function cat($string, $cat)
    {
        return $string . $cat;
    }
}
