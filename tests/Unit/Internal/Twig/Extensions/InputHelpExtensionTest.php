<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Adapter;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\InputHelpLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\InputHelpExtension;

class InputHelpExtensionTest extends \OxidTestCase
{

    /**
     * @var InputHelpExtension
     */
    private $inputHelpExtension;

    protected function setUp()
    {
        parent::setUp();
        $inputHelpLogic = new InputHelpLogic();
        $this->inputHelpExtension = new InputHelpExtension($inputHelpLogic);
    }

    /**
     * @return array
     */
    public function getIdentProvider()
    {
        return array(
            [null, 1, false, null],
            ['FIRST_NAME', 1, false, 'FIRST_NAME']
        );
    }

    /**
     * @param $params
     * @param $iLang
     * @param $blAdmin
     * @param $expected
     *
     * @dataProvider getIdentProvider
     * @covers       \OxidEsales\EshopCommunity\Internal\Twig\Extensions\InputHelpExtension::getHelpId
     */
    public function testGetIdent($params, $iLang, $blAdmin, $expected)
    {
        $this->setLanguage($iLang);
        $this->setAdminMode($blAdmin);
        $this->assertEquals($expected, $this->inputHelpExtension->getHelpId($params));
    }

    /**
     * @return array
     */
    public function getHelpTextProvider()
    {
        return array(
            [null, 1, false, null],
            ['FIRST_NAME', 1, false, 'First name'],
            ['FIRST_NAME', 0, false, 'Vorname'],
            ['GENERAL_SAVE', 1, true, 'Save'],
            ['GENERAL_SAVE', 0, true, 'Speichern'],
            ['VAT', 1, false, 'VAT'],
        );
    }

    /**
     * @param $params
     * @param $iLang
     * @param $blAdmin
     * @param $expected
     *
     * @dataProvider getHelpTextProvider
     * @covers       \OxidEsales\EshopCommunity\Internal\Twig\Extensions\InputHelpExtension::getHelpText
     */
    public function testgetHelpText($params, $iLang, $blAdmin, $expected)
    {
        $this->setLanguage($iLang);
        $this->setAdminMode($blAdmin);
        $this->assertEquals($expected, $this->inputHelpExtension->getHelpText($params));
    }

}
