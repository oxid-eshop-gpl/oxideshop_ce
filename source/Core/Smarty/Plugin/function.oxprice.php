<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatPriceLogic;
use \OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: Output price string
 * add [{oxprice price="..." currency="..."}] where you want to display content
 * price - decimal number: 13; 12.45; 13.01;
 * currency - currency abbreviation: EUR, USD, LTL etc.
 * -------------------------------------------------------------
 *
 * @param array  $params  params
 * @param Smarty &$smarty clever simulation of a method
 *
 * @return string
 */
function smarty_function_oxprice($params, &$smarty)
{
    /** @var FormatPriceLogic $formatPriceLogic */
    $formatPriceLogic = ContainerFactory::getInstance()->getContainer()->get(FormatPriceLogic::class);
    $price = $formatPriceLogic->formatPrice($params);
    return $price;
}
