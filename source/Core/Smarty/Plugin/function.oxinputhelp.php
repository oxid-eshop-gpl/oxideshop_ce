<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\InputHelpLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty function
 * -------------------------------------------------------------
 * Purpose: Output help popup icon and help text
 * add [{oxinputhelp ident="..."}] where you want to display content
 * -------------------------------------------------------------
 *
 * @param array  $params  params
 * @param Smarty &$smarty clever simulation of a method
 *
 * @return string
 */
function smarty_function_oxinputhelp($params, &$smarty)
{
    $container = ContainerFactory::getInstance()->getContainer();
    /** @var InputHelpLogic $oxinputhelpLogic */
    $inputHelpLogic = $container->get(InputHelpLogic::class);

    $sTranslation = $inputHelpLogic->getTranslation($params);
    $sIdent = $inputHelpLogic->getIdent($params);

    if (!$sTranslation || $sTranslation == $sIdent) {
        //no translation, return empty string
        return '';
    }

    //name of template file where is stored message text
    $sTemplate = 'inputhelp.tpl';

    $smarty->assign('sHelpId', $sIdent);
    $smarty->assign('sHelpText', $sTranslation);

    return $smarty->fetch($sTemplate);
}
