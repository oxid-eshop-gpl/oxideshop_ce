<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

/**
 * Admin Manufacturer picture manager.
 * Collects information about Manufacturer's used pictures, there is posibility to
 * upload any other picture, etc.
 * Admin Menu: Master Settings -> Brands/Manufacturers -> Pictures.
 */
class ManufacturerPictures extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * Loads Manufacturer information - pictures, passes data to Smarty
     * engine, returns name of template file "manufacturer_pictures".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $this->_aViewData["edit"] = $oManufacturer = oxNew(\OxidEsales\Eshop\Application\Model\Manufacturer::class);

        $soxId = $this->getEditObjectId();
        if (isset($soxId) && $soxId != "-1") {
            // load object
            $oManufacturer->load($soxId);
            $oManufacturer = $this->updateManufacturer($oManufacturer);

            // variant handling
            if ($oManufacturer->oxManufacturers__oxparentid->value) {
                $oParentManufacturer = oxNew(\OxidEsales\Eshop\Application\Model\Manufacturer::class);
                $oParentManufacturer->load($oManufacturer->oxManufacturers__oxparentid->value);
                $this->_aViewData["parentManufacturer"] = $oParentManufacturer;
                $this->_aViewData["oxparentid"] = $oManufacturer->oxManufacturers__oxparentid->value;
            }
        }

        $this->_aViewData["iManufacturerPicCount"] = Registry::getConfig()->getConfigParam('iManufacturerPicCount');

        if ($this->getViewConfig()->isAltImageServerConfigured()) {
            $config = Registry::getConfig();

            if ($config->getConfigParam('sAltImageUrl')) {
                $this->_aViewData["imageUrl"] = $config->getConfigParam('sAltImageUrl');
            } else {
                $this->_aViewData["imageUrl"] = $config->getConfigParam('sSSLAltImageUrl');
            }
        }

        return "manufacturer_pictures";
    }

    /**
     * Saves (uploads) pictures to server.
     *
     * @return mixed
     */
    public function save()
    {
        $myConfig = Registry::getConfig();

        if ($myConfig->isDemoShop()) {
            // disabling uploading pictures if this is demo shop
            $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\ExceptionToDisplay::class);
            $oEx->setMessage('MANUFACTURER_PICTURES_UPLOADISDISABLED');
            Registry::getUtilsView()->addErrorToDisplay($oEx, false);

            return;
        }

        parent::save();

        $oManufacturer = oxNew(\OxidEsales\Eshop\Application\Model\Manufacturer::class);
        if ($oManufacturer->load($this->getEditObjectId())) {
            $oManufacturer->assign(Registry::getRequest()->getRequestEscapedParameter("editval"));
            Registry::getUtilsFile()->processFiles($oManufacturer);

            // Show that no new image added
            if (Registry::getUtilsFile()->getNewFilesCounter() == 0) {
                $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\ExceptionToDisplay::class);
                $oEx->setMessage('NO_PICTURES_CHANGES');
                Registry::getUtilsView()->addErrorToDisplay($oEx, false);
            }

            $oManufacturer->save();
        }
    }

    /**
     * Deletes selected master picture and all other master pictures
     * where master picture index is higher than currently deleted index.
     * Also deletes custom icon and thumbnail.
     *
     * @return null
     */
    public function deletePicture()
    {
        $myConfig = Registry::getConfig();

        if ($myConfig->isDemoShop()) {
            // disabling uploading pictures if this is demo shop
            $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\ExceptionToDisplay::class);
            $oEx->setMessage('MANUFACTURER_PICTURES_UPLOADISDISABLED');
            Registry::getUtilsView()->addErrorToDisplay($oEx, false);

            return;
        }

        $sOxId = $this->getEditObjectId();
        $iIndex = Registry::getRequest()->getRequestEscapedParameter("masterPicIndex");

        $oManufacturer = oxNew(\OxidEsales\Eshop\Application\Model\Manufacturer::class);
        $oManufacturer->load($sOxId);

        $iIndex = (int) $iIndex;
        if ($iIndex > 0) {
            // deleting master picture
            $this->resetMasterPicture($oManufacturer, $iIndex, true);
        }

        $oManufacturer->save();
    }

    /**
     * Deletes selected master picture and all pictures generated
     * from master picture
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer       Manufacturer object
     * @param int                                         $iIndex         master picture index
     * @param bool                                        $blDeleteMaster if TRUE - deletes and unsets master image file
     */
    protected function resetMasterPicture($oManufacturer, $iIndex, $blDeleteMaster = false)
    {
        if ($this->canResetMasterPicture($oManufacturer, $iIndex)) {
            if (!$oManufacturer->isDerived()) {
                $oPicHandler = Registry::getPictureHandler();
                $oPicHandler->deleteManufacturerMasterPicture($oManufacturer, $iIndex, $blDeleteMaster);
            }

            if ($blDeleteMaster) {
                //reseting master picture field
                $oManufacturer->{"oxmanufacturers__oxpic" . $iIndex} = new \OxidEsales\Eshop\Core\Field();
            }

            // cleaning oxzoom fields
            if (isset($oManufacturer->{"oxmanufacturers__oxzoom" . $iIndex})) {
                $oManufacturer->{"oxmanufacturers__oxzoom" . $iIndex} = new \OxidEsales\Eshop\Core\Field();
            }
        }
    }

    /**
     * Deletes main icon file
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer Manufacturer object
     */
    protected function deleteMainIcon($oManufacturer)
    {
        if ($this->canDeleteMainIcon($oManufacturer)) {
            if (!$oManufacturer->isDerived()) {
                $oPicHandler = Registry::getPictureHandler();
                $oPicHandler->deleteMainIcon($oManufacturer);
            }

            //reseting field
            $oManufacturer->oxManufacturers__oxicon = new \OxidEsales\Eshop\Core\Field();
        }
    }

    /**
     * Deletes thumbnail file
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer Manufacturer object
     */
    protected function deleteThumbnail($oManufacturer)
    {
        if ($this->canDeleteThumbnail($oManufacturer)) {
            if (!$oManufacturer->isDerived()) {
                $oPicHandler = Registry::getPictureHandler();
                $oPicHandler->deleteThumbnail($oManufacturer);
            }

            //reseting field
            $oManufacturer->oxManufacturers__oxthumb = new \OxidEsales\Eshop\Core\Field();
        }
    }

    /**
     * Cleans up Manufacturer custom fields oxicon and oxthumb. If there is custom
     * icon or thumb picture, leaves records untouched.
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer Manufacturer object
     */
    protected function cleanupCustomFields($oManufacturer)
    {
        $sIcon = $oManufacturer->oxManufacturers__oxicon->value;
        $sThumb = $oManufacturer->oxManufacturers__oxthumb->value;

        if ($sIcon == "nopic.jpg") {
            $oManufacturer->oxManufacturers__oxicon = new \OxidEsales\Eshop\Core\Field();
        }

        if ($sThumb == "nopic.jpg") {
            $oManufacturer->oxManufacturers__oxthumb = new \OxidEsales\Eshop\Core\Field();
        }
    }

    /**
     * Method is used for overloading to update Manufacturer object.
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer
     *
     * @return \OxidEsales\Eshop\Application\Model\Manufacturer
     */
    protected function updateManufacturer($oManufacturer)
    {
        return $oManufacturer;
    }

    /**
     * Checks if possible to reset master picture.
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer
     * @param int                                         $masterPictureIndex
     *
     * @return bool
     */
    protected function canResetMasterPicture($oManufacturer, $masterPictureIndex)
    {
        return (bool) $oManufacturer->{"oxmanufacturers__oxpic" . $masterPictureIndex}->value;
    }

    /**
     * Checks if possible to delete main icon of Manufacturer.
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer
     *
     * @return bool
     */
    protected function canDeleteMainIcon($oManufacturer)
    {
        return (bool) $oManufacturer->oxManufacturers__oxicon->value;
    }

    /**
     * Checks if possible to delete thumbnail of Manufacturer.
     *
     * @param \OxidEsales\Eshop\Application\Model\Manufacturer $oManufacturer
     *
     * @return bool
     */
    protected function canDeleteThumbnail($oManufacturer)
    {
        return (bool) $oManufacturer->oxManufacturers__oxthumb->value;
    }
}
