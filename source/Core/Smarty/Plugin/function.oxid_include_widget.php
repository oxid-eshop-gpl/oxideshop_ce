<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\IncludeWidgetLogic;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: set params and render widget
 * Use [{oxid_include_dynamic file="..."}] instead of include
 * -------------------------------------------------------------
 *
 * @param array  $params  Params
 * @param Smarty $oSmarty Clever simulation of a method
 *
 * @return string
 */
function smarty_function_oxid_include_widget($params, &$oSmarty)
{
    /** @var IncludeWidgetLogic $oxgetseourlLogic */
    $assignAdvancedLogic = ContainerFactory::getInstance()->getContainer()->get(IncludeWidgetLogic::class);
    return $assignAdvancedLogic->renderWidget($params);
}
