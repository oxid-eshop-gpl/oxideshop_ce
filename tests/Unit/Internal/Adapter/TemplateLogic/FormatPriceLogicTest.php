<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extension;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatPriceLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\FormatPriceExtension;
use PHPUnit\Framework\TestCase;

class FormatPriceLogicTest extends TestCase
{

    /**
     * @var FormatPriceExtension
     */
    private $formatPriceLogic;

    protected function setUp()
    {
        $this->formatPriceLogic = new FormatPriceLogic();
        parent::setUp();
    }

    /**
     * @param $params
     * @param $expected
     *
     * @dataProvider getFormatPriceProvider
     */
    public function testFormatPrice($params, $expected)
    {
        $price = $this->formatPriceLogic->formatPrice($params);
        $this->assertEquals($expected, $price);
    }

    public function getFormatPriceProvider()
    {
        return [
            [
                ['price' => 100],
                '100,00 €'
            ],
            [
                ['price' => null],
                ''
            ]
        ];
    }

    /**
     * @param $inputPrice
     * @param $expected
     *
     * @dataProvider getCalculatePriceProvider
     */
    public function testCalculatePrice($inputPrice, $expected)
    {
        $params['price'] = $inputPrice;
        $calculatedOxPrice = $this->formatPriceLogic->formatPrice($params);
        $this->assertEquals($expected, $calculatedOxPrice);
    }

    /**
     * @return array
     */
    public function getCalculatePriceProvider()
    {
        $incorrectPriceObj = new \OxidEsales\Eshop\Core\Price();
        $incorrectPriceObj->setPrice(false);
        $correctPriceObj = new \OxidEsales\Eshop\Core\Price();
        $correctPriceObj->setPrice(120);

        return [
            [
                1, '1,00 €'
            ],
            [
                'incorrect', '0,00 €'
            ],
            [
                $incorrectPriceObj, '0,00 €'
            ],
            [
                $incorrectPriceObj, '0,00 €'
            ],
            [
                $correctPriceObj, '120,00 €'
            ]
        ];
    }

    /**
     * @param $currency
     * @param $price
     * @param $expected
     *
     * @dataProvider getFormattedPriceProvider
     */
    public function testGetFormattedPrice($currency, $price, $expected)
    {
        $params['currency'] = $currency;
        $params['price'] = $price;
        $formattedPrice = $this->formatPriceLogic->formatPrice($params);
        $this->assertEquals($expected, $formattedPrice);
    }

    /**
     * @return array
     */
    public function getFormattedPriceProvider()
    {
        $price = 10000;

        return [
            [
                '', $price, '10.000,00'
            ],
            [
                '', -100, ''
            ],
            [
                $this->getCurrencyWithSeparator(['dec' => '-']), $price, '10.000-00'
            ],
            [
                $this->getCurrencyWithSeparator(['thousand' => '-']), $price, '10-000,00'
            ],
            [
                $this->getCurrencyWithSeparator(['sign' => '$']), $price, '10.000,00 $'
            ],
            [
                $this->getCurrencyWithSeparator(['decimal' => 4]), $price, '10.000,0000'
            ],
            [
                $this->getCurrencyWithSeparator(['sign' => '$', 'side' => 'Front']), $price, '$10.000,00'
            ],
            [
                $this->getCurrencyWithSeparator(['sign' => '$', 'side' => 'incorrect']), $price, '10.000,00 $'
            ]
        ];
    }

    /**
     * @param $currency_array
     *
     * @return \stdClass
     */
    private function getCurrencyWithSeparator($currency_array)
    {
        $currency = new \stdClass();
        foreach ($currency_array as $key => $value) {
            $currency->$key = $value;
        }

        return $currency;
    }

}
