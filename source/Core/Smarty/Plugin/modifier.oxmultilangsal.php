<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\TranslateSalutationLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: Output translated salutation field
 * add [{$}] where you want to display content
 * -------------------------------------------------------------
 *
 * @param string $sIdent language constant ident
 *
 * @return string
 */
function smarty_modifier_oxmultilangsal( $sIdent )
{
    /** @var TranslateSalutationLogic $translateSalutationLogic */
    $translateSalutationLogic = ContainerFactory::getInstance()->getContainer()->get(TranslateSalutationLogic::class);

    return $translateSalutationLogic->translateSalutation($sIdent);
}
