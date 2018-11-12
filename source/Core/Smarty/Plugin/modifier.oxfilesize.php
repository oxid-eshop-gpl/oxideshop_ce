<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

use \OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FileSizeLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty modifier
 * -------------------------------------------------------------
 * Name:     oxfilesize<br>
 * Purpose:  {$var|oxfilesize} Convert integer file size to readable format
 * -------------------------------------------------------------
 *
 * @param int $size Integer size value
 *
 * @return string
 */
function smarty_modifier_oxfilesize($size)
{

    /** @var FileSizeLogic $fileSizeLogic */
    $fileSizeLogic = ContainerFactory::getInstance()->getContainer()->get(FileSizeLogic::class);

    return $fileSizeLogic->getFileSize($size);
}
