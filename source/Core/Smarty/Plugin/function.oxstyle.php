<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\StyleLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.oxstyle.php
 * Type: string, html
 * Name: oxstyle
 * Purpose: Collect given css files. but include them only at the top of the page.
 *
 * Add [{oxstyle include="oxid.css"}] to include local css file.
 * Add [{oxstyle include="oxid.css?20120413"}] to include local css file with query string part.
 * Add [{oxstyle include="http://www.oxid-esales.com/oxid.css"}] to include external css file.
 *
 * IMPORTANT!
 * Do not forget to add plain [{oxstyle}] tag where you need to output all collected css includes.
 * -------------------------------------------------------------
 *
 * @param array  $params params
 * @param Smarty &$smarty clever simulation of a method
 *
 * @return string
 */
function smarty_function_oxstyle($params, &$smarty)
{
    $isDynamic = isset($smarty->_tpl_vars["__oxid_include_dynamic"]) ? (bool) $smarty->_tpl_vars["__oxid_include_dynamic"] : false;
    /**@var StyleLogic $styleLogic */
    $styleLogic = ContainerFactory::getInstance()->getContainer()->get(StyleLogic::class);
    $output = $styleLogic->collectStyleSheets($params, $isDynamic);

    return $output;
}
