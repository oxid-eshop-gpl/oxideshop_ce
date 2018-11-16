<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormDateLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty modifier
 * -------------------------------------------------------------
 * Name:     smarty_modifier_oxformdate<br>
 * Purpose:  Conterts date/timestamp/datetime type value to user defined format
 * Example:  {$object|oxformdate:"foo"}
 * -------------------------------------------------------------
 *
 * @param object $oConvObject   oxField object
 * @param string $sFieldType    additional type if field (this may help to force formatting)
 * @param bool   $blPassedValue bool if true, will simulate object as sometimes we need to apply formatting to some regulat values
 *
 * @return string
 */
function smarty_modifier_oxformdate( $oConvObject, $sFieldType = null, $blPassedValue = false)
{
    /** @var FormDateLogic $formDateLogic */
    $formDateLogic = ContainerFactory::getInstance()->getContainer()->get(FormDateLogic::class);

    return $formDateLogic->formdate($oConvObject, $sFieldType, $blPassedValue);
}

/* vim: set expandtab: */
