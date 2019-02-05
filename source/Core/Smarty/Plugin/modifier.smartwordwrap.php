<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage plugins
 */

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\SmartWordwrapLogic;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;

/**
 * Smarty smartwordwrap modifier plugin
 *
 * Type:     modifier<br>
 * Name:     smartwordwrap<br>
 * Purpose:  wrap a string of text at a given length and row count
 *
 * @param string
 * @param integer
 * @param string
 * @param integer
 *
 * @return integer
 */
function smarty_modifier_smartwordwrap($string, $length = 80, $break = "\n", $cutrows = 0, $tollerance = 0, $etc = '...')
{
    /** @var SmartWordwrapLogic $smartWordWrapLogic */
    $smartWordWrapLogic = ContainerFactory::getInstance()->getContainer()->get(SmartWordwrapLogic::class);

    return $smartWordWrapLogic->wrapWords($string, $length, $break, $cutrows, $tollerance, $etc);
}

?>