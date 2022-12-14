<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

/**
 * Admin user extended settings manager.
 * Collects user extended settings, updates it on user submit, etc.
 * Admin Menu: User Administration -> Users -> Extended.
 */
class UserExtend extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * Executes parent method parent::render(), creates oxuser object and
     * returns name of template file "user_extend".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $soxId = $this->getEditObjectId();
        if (isset($soxId) && $soxId != "-1") {
            // load object
            $oUser = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
            $oUser->load($soxId);

            //show country in active language
            $oCountry = oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
            $oCountry->loadInLang(\OxidEsales\Eshop\Core\Registry::getLang()->getObjectTplLanguage(), $oUser->oxuser__oxcountryid->value);
            $oUser->oxuser__oxcountry = new \OxidEsales\Eshop\Core\Field($oCountry->oxcountry__oxtitle->value);

            $this->_aViewData["edit"] = $oUser;
        }

        if (!$this->allowAdminEdit($soxId)) {
            $this->_aViewData['readonly'] = true;
        }

        return "user_extend";
    }

    /**
     * Saves user extended information.
     *
     * @return mixed
     */
    public function save()
    {
        parent::save();

        $soxId = $this->getEditObjectId();

        if (!$this->allowAdminEdit($soxId)) {
            return false;
        }

        $aParams = Registry::getRequest()->getRequestEscapedParameter("editval");

        $oUser = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
        if ($soxId != "-1") {
            $oUser->load($soxId);
        } else {
            $aParams['oxuser__oxid'] = null;
        }

        // checkbox handling
        $aParams['oxuser__oxactive'] = $oUser->oxuser__oxactive->value;

        $blNewsParams = Registry::getRequest()->getRequestEscapedParameter("editnews");
        if (isset($blNewsParams)) {
            $oNewsSubscription = $oUser->getNewsSubscription();
            $oNewsSubscription->setOptInStatus((int) $blNewsParams);
            $oNewsSubscription->setOptInEmailStatus((int) Registry::getRequest()->getRequestEscapedParameter("emailfailed"));
        }

        $oUser->assign($aParams);
        $oUser->save();

        // set oxid if inserted
        $this->setEditObjectId($oUser->getId());
    }
}
