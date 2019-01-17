<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\InsertNewBasketItemLogicSmarty;

/**
 * Smarty plugin
 * -------------------------------------------------------------
 * File: insert.oxid_newbasketitem.php
 * Type: string, html
 * Name: newbasketitem
 * Purpose: Used for tracking in econda, etracker etc.
 * -------------------------------------------------------------
 *
 * @param array   $params params
 * @param Smarty &$smarty clever simulation of a method
 *
 * @return string
 */
function smarty_insert_oxid_newbasketitem($params, &$smarty)
{
    /**
     * @var InsertNewBasketItemLogicSmarty $insertNewBasketItemLogic
     */
    $insertNewBasketItemLogic = ContainerFactory::getInstance()->getContainer()->get(InsertNewBasketItemLogicSmarty::class);

    return $insertNewBasketItemLogic->getNewBasketItemTemplate($params, $smarty);
}
