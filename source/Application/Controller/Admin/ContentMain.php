<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use stdClass;
use OxidEsales\Eshop\Core\Str;

/**
 * Admin content manager.
 * There is possibility to change content description, enter page text etc.
 * Admin Menu: Customerinformations -> Content.
 */
class ContentMain extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /** @inheritdoc */
    public function render()
    {
        $myConfig = \OxidEsales\Eshop\Core\Registry::getConfig();

        parent::render();

        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();

        // categorie tree
        $oCatTree = oxNew(\OxidEsales\Eshop\Application\Model\CategoryList::class);
        $oCatTree->loadList();

        $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);
        if (isset($soxId) && $soxId != "-1") {
            // load object
            $oContent->loadInLang($this->_iEditLang, $soxId);

            $oOtherLang = $oContent->getAvailableInLangs();
            if (!isset($oOtherLang[$this->_iEditLang])) {
                // echo "language entry doesn't exist! using: ".key($oOtherLang);
                $oContent->loadInLang(key($oOtherLang), $soxId);
            }

            // remove already created languages
            $aLang = array_diff(\OxidEsales\Eshop\Core\Registry::getLang()->getLanguageNames(), $oOtherLang);
            if (count($aLang)) {
                $this->_aViewData["posslang"] = $aLang;
            }
            foreach ($oOtherLang as $id => $language) {
                $oLang = new stdClass();
                $oLang->sLangDesc = $language;
                $oLang->selected = ($id == $this->_iEditLang);
                $this->_aViewData["otherlang"][$id] = clone $oLang;
            }
            // mark selected
            if ($oContent->oxcontents__oxcatid->value && isset($oCatTree[$oContent->oxcontents__oxcatid->value])) {
                $oCatTree[$oContent->oxcontents__oxcatid->value]->selected = 1;
            }
        } else {
            // create ident to make life easier
            $sUId = \OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUId();
            $oContent->oxcontents__oxloadid = new \OxidEsales\Eshop\Core\Field($sUId);
        }

        $this->_aViewData["edit"] = $oContent;
        $this->_aViewData["link"] = "[{ oxgetseourl ident=&quot;" . $oContent->oxcontents__oxloadid->value . "&quot; type=&quot;oxcontent&quot; }]";
        $this->_aViewData["cattree"] = $oCatTree;

        // generate editor
        $sCSS = "content.css";
        if ($oContent->oxcontents__oxsnippet->value == '1') {
            $sCSS = null;
        }

        $this->_aViewData["editor"] = $this->generateTextEditor("100%", 300, $oContent, "oxcontents__oxcontent", $sCSS);
        $this->_aViewData["afolder"] = $myConfig->getConfigParam('aCMSfolder');

        return "content_main";
    }

    /**
     * Saves content contents.
     *
     * @return mixed
     */
    public function save()
    {
        parent::save();

        $soxId = $this->getEditObjectId();
        $aParams = Registry::getRequest()->getRequestEscapedParameter("editval");

        if (isset($aParams['oxcontents__oxloadid'])) {
            $aParams['oxcontents__oxloadid'] = $this->prepareIdent($aParams['oxcontents__oxloadid']);
        }

        // check if loadid is unique
        if ($this->checkIdent($aParams['oxcontents__oxloadid'], $soxId)) {
            // loadid already used, display error message
            $this->_aViewData["blLoadError"] = true;

            $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);
            if ($soxId != '-1') {
                $oContent->load($soxId);
            }
            $oContent->assign($aParams);
            $this->_aViewData["edit"] = $oContent;

            return;
        }

        // checkbox handling
        if (!isset($aParams['oxcontents__oxactive'])) {
            $aParams['oxcontents__oxactive'] = 0;
        }

        // special treatment
        if ($aParams['oxcontents__oxtype'] == 0) {
            $aParams['oxcontents__oxsnippet'] = 1;
        } else {
            $aParams['oxcontents__oxsnippet'] = 0;
        }

        //Updates object folder parameters
        if ($aParams['oxcontents__oxfolder'] == 'CMSFOLDER_NONE') {
            $aParams['oxcontents__oxfolder'] = '';
        }

        $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);

        if ($soxId != "-1") {
            $oContent->loadInLang($this->_iEditLang, $soxId);
        } else {
            $aParams['oxcontents__oxid'] = null;
        }

        //$aParams = $oContent->ConvertNameArray2Idx( $aParams);

        $oContent->setLanguage(0);
        $oContent->assign($aParams);
        $oContent->setLanguage($this->_iEditLang);
        $oContent->save();

        // set oxid if inserted
        $this->setEditObjectId($oContent->getId());
    }

    /**
     * Saves content data to different language (eg. english).
     */
    public function saveinnlang()
    {
        parent::save();

        $soxId = $this->getEditObjectId();
        $aParams = Registry::getRequest()->getRequestEscapedParameter("editval");

        if (isset($aParams['oxcontents__oxloadid'])) {
            $aParams['oxcontents__oxloadid'] = $this->prepareIdent($aParams['oxcontents__oxloadid']);
        }

        // checkbox handling
        if (!isset($aParams['oxcontents__oxactive'])) {
            $aParams['oxcontents__oxactive'] = 0;
        }

        $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);

        if ($soxId != "-1") {
            $oContent->loadInLang($this->_iEditLang, $soxId);
        } else {
            $aParams['oxcontents__oxid'] = null;
        }

        $oContent->setLanguage(0);
        $oContent->assign($aParams);

        // apply new language
        $oContent->setLanguage(Registry::getRequest()->getRequestEscapedParameter("new_lang"));
        $oContent->save();

        // set oxid if inserted
        $this->setEditObjectId($oContent->getId());
    }

    /**
     * Prepares ident (removes bad chars, leaves only thoose that fits in a-zA-Z0-9_ range)
     *
     * @param string $sIdent ident to filter
     *
     * @return string
     */
    protected function prepareIdent($sIdent)
    {
        if ($sIdent) {
            return Str::getStr()->preg_replace("/[^a-zA-Z0-9_]*/", "", $sIdent);
        }
    }

    /**
     * Check if ident is unique
     *
     * @param string $sIdent ident
     * @param string $sOxId  Object id
     *
     * @return null
     */
    protected function checkIdent($sIdent, $sOxId)
    {
        // We force reading from master to prevent issues with slow replications or open transactions (see ESDEV-3804).
        $masterDb = \OxidEsales\Eshop\Core\DatabaseProvider::getMaster();

        $blAllow = false;

        // null not allowed
        if (!strlen($sIdent)) {
            $blAllow = true;
        // We force reading from master to prevent issues with slow replications or open transactions (see ESDEV-3804).
        } elseif (
            $masterDb->getOne("select oxid from oxcontents where oxloadid = :oxloadid and oxid != :oxid and oxshopid = :oxshopid", [
            ':oxloadid' => $sIdent,
            ':oxid' => $sOxId,
            ':oxshopid' => \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId()
            ])
        ) {
            $blAllow = true;
        }

        return $blAllow;
    }
}
