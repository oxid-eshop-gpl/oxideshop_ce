<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\TranslateLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: Modifies provided language constant with it's translation
 * usage: [{$val|oxmultilangassign}]
 * -------------------------------------------------------------
 *
 * @param string $sIdent language constant ident
 * @param mixed  $args   for constants using %s notations
 *
 * @return string
 */
function smarty_modifier_oxmultilangassign( $sIdent, $args = null )
{
    /** @var TranslateLogic $multiLangLogic */
    $translateLogic = ContainerFactory::getInstance()->getContainer()->get(TranslateLogic::class);

    return $translateLogic->translate($sIdent, $args);
}
