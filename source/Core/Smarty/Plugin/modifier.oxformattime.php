<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use \OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatTimeLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty modifier
 * -------------------------------------------------------------
 * Name:     smarty_modifier_oxformattime<br>
 * Purpose:  Converts integer (seconds) type value to time (hh:mm:ss) format
 * Example:  {$seconds|oxformattime}
 * -------------------------------------------------------------
 *
 * @param int $iSeconds timespan in seconds
 *
 * @return string
 */
function smarty_modifier_oxformattime($iSeconds)
{
    /** @var FormatTimeLogic $formatTimeLogic */
    $formatTimeLogic = ContainerFactory::getInstance()->getContainer()->get(FormatTimeLogic::class);

    return $formatTimeLogic->getFormattedTime($iSeconds);
}

/* vim: set expandtab: */
