<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

require_once dirname(__FILE__) . "/bootstrap.php";

/**
 * Redirect to Setup, if shop is not configured
 */
redirectIfShopNotConfigured();

//force twig theme
//$themeName = 'flow';
$themeName = 'twig';
$shopId = 1;

$currentShopId = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
\OxidEsales\Eshop\Core\Registry::getConfig()->setShopId($shopId);

$theme = oxNew( \OxidEsales\Eshop\Core\Theme::class);
$theme->load($themeName);
$theme->activate();

\OxidEsales\Eshop\Core\Registry::getConfig()->setShopId($currentShopId);

//Starts the shop
OxidEsales\EshopCommunity\Core\Oxid::run();
