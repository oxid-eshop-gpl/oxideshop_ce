<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use OxidEsales\Eshop\Application\Model\PriceAlarm;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Email;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Application\Controller\FrontendController;
use stdClass;

/**
 * Admin article main pricealarm manager.
 * Performs collection and updatind (on user submit) main item information.
 * Admin Menu: Customer Info -> pricealarm -> Main.
 */
class PriceAlarmMain extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * Executes parent method parent::render(), creates oxpricealarm object
     * and passes it's data to template engine. Returns name of template file
     * "pricealarm_main.tpl".
     *
     * @return string
     */
    public function render()
    {
        $config = Registry::getConfig();

        $this->_aViewData['iAllCnt'] = $this->getActivePriceAlarmsCount();

        $oxid = $this->_aViewData["oxid"] = $this->getEditObjectId();
        if (isset($oxid) && $oxid != "-1") {
            // load object
            $priceAlarm = oxNew(PriceAlarm::class);
            $priceAlarm->load($oxid);

            // customer info
            $user = null;
            if ($priceAlarm->oxpricealarm__oxuserid->value) {
                $user = oxNew(User::class);
                $user->load($priceAlarm->oxpricealarm__oxuserid->value);
                $priceAlarm->oUser = $user;
            }

            $shop = oxNew(\OxidEsales\Eshop\Application\Model\Shop::class);
            $shop->load($config->getShopId());
            $this->addGlobalParams($shop);

            if (!($lang = $priceAlarm->oxpricealarm__oxlang->value)) {
                $lang = 0;
            }

            $language = Registry::getLang();
            $languageNames = $language->getLanguageNames();
            $this->_aViewData["edit_lang"] = $languageNames[$lang];
            // rendering mail message text
            $letter = new stdClass();
            $parameter = Registry::getConfig()->getRequestParameter("editval");
            if (isset($parameter['oxpricealarm__oxlongdesc']) && $parameter['oxpricealarm__oxlongdesc']) {
                $letter->oxpricealarm__oxlongdesc = new Field(stripslashes($parameter['oxpricealarm__oxlongdesc']), Field::T_RAW);
            } else {
                $email = oxNew(\OxidEsales\Eshop\Core\Email::class);
                $description = $email->sendPricealarmToCustomer($priceAlarm->oxpricealarm__oxemail->value, $priceAlarm, null, true);

                $tplLanguage = $language->getTplLanguage();
                $language->setTplLanguage($lang);
                $letter->oxpricealarm__oxlongdesc = new Field($description, Field::T_RAW);
                $language->setTplLanguage($tplLanguage);
            }

            $this->_aViewData["editor"] = $this->_generateTextEditor("100%", 300, $letter, "oxpricealarm__oxlongdesc", "details.tpl.css");
            $this->_aViewData["edit"] = $priceAlarm;
            $this->_aViewData["actshop"] = $config->getShopId();
        }

        parent::render();

        return "pricealarm_main.tpl";
    }

    /**
     * Sending email to selected customer
     */
    public function send()
    {
        $errorOccur = true;

        if (($oxid = $this->getEditObjectId())) {
            $priceAlarm = oxNew(PriceAlarm::class);
            $priceAlarm->load($oxid);

            $mailBody = $this->getMailBody($priceAlarm);

            $recipient = $priceAlarm->oxpricealarm__oxemail->value;

            $email = oxNew(Email::class);
            $sendSuccessful = (int) $email->sendPricealarmToCustomer($recipient, $priceAlarm, $mailBody);

            // setting result message
            if ($sendSuccessful) {
                $priceAlarm->oxpricealarm__oxsended->setValue(date("Y-m-d H:i:s"));
                $priceAlarm->save();
                $errorOccur = false;
            }
        }

        if (!$errorOccur) {
            $this->_aViewData["mail_succ"] = 1;
        } else {
            $this->_aViewData["mail_err"] = 1;
        }
    }

    /**
     * Returns number of active price alarms.
     *
     * @return int
     */
    protected function getActivePriceAlarmsCount()
    {
        // #1140 R - price must be checked from the object.
        $query = "
            SELECT oxarticles.oxid, oxpricealarm.oxprice
            FROM oxpricealarm, oxarticles
            WHERE oxarticles.oxid = oxpricealarm.oxartid AND oxpricealarm.oxsended = '000-00-00 00:00:00'";
        $result = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query);
        $count = 0;

        if ($result != false && $result->count() > 0) {
            while (!$result->EOF) {
                $article = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
                $article->load($result->fields[0]);
                if ($article->getPrice()->getBruttoPrice() <= $result->fields[1]) {
                    $count++;
                }
                $result->fetchRow();
            }
        }

        return $count;
    }

    /**
     * @param PriceAlarm $priceAlarm
     * @return string
     */
    private function getMailBody(PriceAlarm $priceAlarm): string
    {
        $parameter = Registry::getConfig()->getRequestParameter("editval");
        $mailBody = isset($parameter['oxpricealarm__oxlongdesc']) ? stripslashes($parameter['oxpricealarm__oxlongdesc']) : '';
        if ($mailBody) {
            $activeView = oxNew(FrontendController::class);
            $activeView->addGlobalParams();
            $mailBody = Registry::getUtilsView()->getRenderedContent(
                $mailBody,
                $activeView->getViewData(),
                $priceAlarm->getId()
            );
        }
        return $mailBody;
    }
}
