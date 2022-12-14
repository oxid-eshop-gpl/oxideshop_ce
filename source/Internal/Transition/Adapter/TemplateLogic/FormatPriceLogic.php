<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic;

use OxidEsales\Eshop\Core\Price;
use OxidEsales\Eshop\Core\Registry;

class FormatPriceLogic
{
    /**
     * @param array $params
     *
     * @return string
     */
    public function formatPrice(array $params): string
    {
        $output = '';
        $inputPrice = $params['price'];
        if (!is_null($inputPrice)) {
            $output = $this->calculatePrice($inputPrice, $params);
        }

        return $output;
    }

    /**
     * @param mixed $inputPrice
     * @param array $params
     *
     * @return string
     */
    private function calculatePrice($inputPrice, array $params): string
    {
        $config = Registry::getConfig();
        $price = ($inputPrice instanceof Price) ? $inputPrice->getPrice() : (float) $inputPrice;
        $currency = isset($params['currency']) ? (object) $params['currency'] : $config->getActShopCurrencyObject();
        $output = '';

        if (is_numeric($price)) {
            $output = $this->getFormattedPrice($currency, $price);
        }

        return $output;
    }

    /**
     * @param object $currency active currency object
     * @param mixed  $price
     *
     * @return string
     */
    private function getFormattedPrice($currency, $price): string
    {
        $output = '';
        $decimalSeparator = $currency->dec ?? ',';
        $thousandsSeparator = $currency->thousand ?? '.';
        $currencySymbol = $currency->sign ?? '';
        $currencySymbolLocation = $currency->side ?? '';
        $decimals = isset($currency->decimal) ? (int) $currency->decimal : 2;

        if ((float) $price > 0 || $currencySymbol) {
            $price = number_format($price, $decimals, $decimalSeparator, $thousandsSeparator);
            $output = (isset($currencySymbolLocation) && $currencySymbolLocation == 'Front')
                ? $currencySymbol . $price
                : $price . ' ' . $currencySymbol;
        }

        return trim($output);
    }
}
