<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use \OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\TranslateFunctionLogic;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: Output multilang string
 * add [{oxmultilang ident="..." args=...}] where you want to display content
 * ident - language constant
 * args - array of argument that can be parsed to language constant threw %s
 * -------------------------------------------------------------
 *
 * @param array  $params  params
 * @param Smarty &$smarty clever simulation of a method
 *
 * @return string
*/
function smarty_function_oxmultilang( $params, &$smarty )
{
    /** @var TranslateFunctionLogic $multiLangFunctionLogic */
    $multiLangFunctionLogic = ContainerFactory::getInstance()->getContainer()->get(TranslateFunctionLogic::class);
    $translation = $multiLangFunctionLogic->getTranslation($params);
    return $translation;
}
