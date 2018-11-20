<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\MultiLangLogic;
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
    /** @var MultiLangLogic $multiLangLogic */
    $multiLangLogic = ContainerFactory::getInstance()->getContainer()->get(MultiLangLogic::class);

    return $multiLangLogic->multiLang($sIdent, $args);
}
