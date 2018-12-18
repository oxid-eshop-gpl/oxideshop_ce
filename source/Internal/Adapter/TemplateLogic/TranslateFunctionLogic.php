<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic;

use OxidEsales\EshopCommunity\Core\Language;

/**
 * Class TranslateFunctionLogic
 *
 * @package OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic
 * @author  Jędrzej Skoczek
 */
class TranslateFunctionLogic
{

    /**
     * @param array $params
     *
     * @return string
     */
    public function getTranslation(array $params) : string
    {
        startProfile("smarty_function_oxmultilang");

        /**
         * @var Language $lang
         */
        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();
        $shop = $config->getActiveShop();
        $admin = $lang->isAdmin();

        $ident = isset($params['ident']) ? $params['ident'] : 'IDENT MISSING';
        $args = isset($params['args']) ? $params['args'] : false;
        $suffix = isset($params['suffix']) ? $params['suffix'] : 'NO_SUFFIX';
        $showError = isset($params['noerror']) ? !$params['noerror'] : true;

        $tplLanguage = $lang->getTplLanguage();

        if (!$admin && $shop->isProductiveMode()) {
            $showError = false;
        }

        $translation = '';

        try {
            $translation = $lang->translateString($ident, $tplLanguage, $admin);
            $translationNotFound = !$lang->isTranslated();
            if ('NO_SUFFIX' != $suffix) {
                $suffixTranslation = $lang->translateString($suffix, $tplLanguage, $admin);
            }
        } catch (\OxidEsales\Eshop\Core\Exception\LanguageException $exception) {
            // is thrown in debug mode and has to be caught here, as smarty hangs otherwise!
        }

        if (isset($translationNotFound) && isset($params['alternative'])) {
            $translation = $params['alternative'];
            $translationNotFound = false;
        }

        if (!isset($translationNotFound) || !$translationNotFound) {
            if ($args !== false) {
                if (is_array($args)) {
                    $translation = vsprintf($translation, $args);
                } else {
                    $translation = sprintf($translation, $args);
                }
            }

            if ('NO_SUFFIX' != $suffix) {
                $translation .= $suffixTranslation;
            }
        } elseif ($showError) {
            $translation = 'ERROR: Translation for ' . $ident . ' not found!';
        }

        stopProfile("smarty_function_oxmultilang");

        return $translation;
    }
}
