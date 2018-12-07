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
        $this->InputHelpExtension = new InputHelpExtension($inputHelpLogic);
    }

    /**
     * @return array
     */
    public function getIdentProvider()
    {
        return array(
            [[], 1, false, null],
            [['ident' => 'FIRST_NAME'], 1, false, 'FIRST_NAME']
        );
    }

    /**
     * @param $params
     * @param $iLang
     * @param $blAdmin
     * @param $expected
     *
     * @dataProvider getIdentProvider
     * @covers       \OxidEsales\EshopCommunity\Internal\Twig\Extensions\InputHelpExtension::getSHelpId
     */
    public function testGetIdent($params, $iLang, $blAdmin, $expected)
    {
        $this->setLanguage($iLang);
        $this->setAdminMode($blAdmin);
        $this->assertEquals($expected, $this->InputHelpExtension->getSHelpId($params));
    }

    /**
     * @return array
     */
    public function getSHelpTextProvider()
    {
        return array(
            [[], 1, false, null],
            [['ident' => 'FIRST_NAME'], 1, false, 'First name'],
            [['ident' => 'FIRST_NAME'], 0, false, 'Vorname'],
            [['ident' => 'GENERAL_SAVE'], 1, true, 'Save'],
            [['ident' => 'GENERAL_SAVE'], 0, true, 'Speichern'],
            [['ident' => 'VAT'], 1, false, 'VAT'],
        );
    }

    /**
     * @param $params
     * @param $iLang
     * @param $blAdmin
     * @param $expected
     *
     * @dataProvider getSHelpTextProvider
     * @covers       \OxidEsales\EshopCommunity\Internal\Twig\Extensions\InputHelpExtension::getSHelpText
     */
    public function testGetSHelpText($params, $iLang, $blAdmin, $expected)
    {
        $this->setLanguage($iLang);
        $this->setAdminMode($blAdmin);
        $this->assertEquals($expected, $this->InputHelpExtension->getSHelpText($params));
    }

}
