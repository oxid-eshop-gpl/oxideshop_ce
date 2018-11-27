<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\NumberFormatLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty modifier
 * -------------------------------------------------------------
 * Name:     smarty_modifier_oxnumberformat<br>
 * Purpose:  Formats number for chosen locale
 * Example:  $object = "EUR@ 1.00@ ,@ .@ EUR@ 2"{$object|oxnumberformat:2000.123}
 * -------------------------------------------------------------
 *
 * @param string $sFormat Number formatting rules (use default currency formatting rules defined in Admin)
 * @param string $sValue  Number to format
 *
 * @return string
 */
function smarty_modifier_oxnumberformat( $sFormat = "EUR@ 1.00@ ,@ .@ EUR@ 2", $sValue = 0)
{
    /** @var NumberFormatLogic $numberFormatLogic */
    $numberFormatLogic = ContainerFactory::getInstance()->getContainer()->get(NumberFormatLogic::class);

    return $numberFormatLogic->numberFormat($sFormat, $sValue);
}
