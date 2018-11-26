<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use Twig\Extension\AbstractExtension;

/**
 * Class EncloseExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 * @author  Jędrzej Skoczek
 */
class EncloseExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('enclose', [$this, 'enclose'])];
    }

    /**
     * @param string $string
     * @param string $encloser
     *
     * @return string
     */
    public function enclose($string, $encloser = "")
    {
        return $encloser . $string . $encloser;
    }
}
