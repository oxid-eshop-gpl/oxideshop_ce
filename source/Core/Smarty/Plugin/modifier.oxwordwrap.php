<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\WordwrapLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;


/**
 * Smarty wordwrap modifier
 * -------------------------------------------------------------
 * Name:     wordwrap<br>
 * Purpose:  wrap a string of text at a given length
 * -------------------------------------------------------------
 *
 * @param string  $sString String to wrap
 * @param integer $iLength To length
 * @param string  $sWraper wrap using
 * @param bool    $blCut   Cut
 *
 * @return string
 */
function smarty_modifier_oxwordwrap($sString, $iLength=80, $sWraper="\n", $blCut=false)
{
    /** @var WordwrapLogic $wordWrapLogic */
    $wordWrapLogic = ContainerFactory::getInstance()->getContainer()->get(WordwrapLogic::class);

    return $wordWrapLogic->wordwrap($sString, $iLength, $sWraper, $blCut);
}

?>
