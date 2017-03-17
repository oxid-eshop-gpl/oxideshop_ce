<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2017
 * @version   OXID eShop CE
 */
namespace OxidEsales\EshopCommunity\Application\Component;

use OxidEsales\Eshop\Core\Registry;

/**
 * Builder for the URL of the suggest controller.
 */
class SuggestUrlBuilder
{
    /**
     * Build the URL for the method send.
     *
     * @return string The URL.
     */
    public function buildUrl()
    {
        $sReturn = "";

        // #1834M - specialchar search
        $sSearchParamForLink = rawurlencode(Registry::getConfig()->getRequestParameter('searchparam', true));
        if ($sSearchParamForLink) {
            $sReturn .= "&searchparam=$sSearchParamForLink";
        }

        $sSearchCatId = Registry::getConfig()->getRequestParameter('searchcnid');
        if ($sSearchCatId) {
            $sReturn .= "&searchcnid=$sSearchCatId";
        }

        $sSearchVendor = Registry::getConfig()->getRequestParameter('searchvendor');
        if ($sSearchVendor) {
            $sReturn .= "&searchvendor=$sSearchVendor";
        }

        if (($sSearchManufacturer = Registry::getConfig()->getRequestParameter('searchmanufacturer'))) {
            $sReturn .= "&searchmanufacturer=$sSearchManufacturer";
        }

        $sListType = Registry::getConfig()->getRequestParameter('listtype');
        if ($sListType) {
            $sReturn .= "&listtype=$sListType";
        }

        return $sReturn;
    }
}
