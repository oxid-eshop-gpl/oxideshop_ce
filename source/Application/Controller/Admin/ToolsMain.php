<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use oxRegistry;

/**
 * CVS export manager.
 * Performs export function according to user chosen categories.
 * Admin Menu: Maine Menu -> Im/Export -> Export.
 */
class ToolsMain extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /** @inheritdoc */
    public function render()
    {
        if (\OxidEsales\Eshop\Core\Registry::getConfig()->isDemoShop()) {
            \OxidEsales\Eshop\Core\Registry::getUtils()->showMessageAndExit("Access denied !");
        }

        parent::render();

        $oAuthUser = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
        $oAuthUser->loadAdminUser();
        $this->_aViewData["blIsMallAdmin"] = $oAuthUser->oxuser__oxrights->value == "malladmin";

        $blShowUpdateViews = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('blShowUpdateViews');
        $this->_aViewData['showViewUpdate'] = (isset($blShowUpdateViews) && !$blShowUpdateViews) ? false : true;

        return "tools_main";
    }
}
