<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Application\Controller\Admin;

use \oxDb;

/**
 * Tests for Object_Seo class
 */
class ObjectSeoTest extends \OxidTestCase
{

    /**
     * Tear down the fixture.
     *
     * @return null
     */
    protected function tearDown(): void
    {
        $sQ = "delete from oxseo where oxobjectid='objectid'";
        oxDb::getDb()->execute($sQ);

        parent::tearDown();
    }

    /**
     * Testing Object_Seo::isEntrySuffixed()
     *
     * @return null
     */
    public function testIsEntrySuffixed()
    {
        $oView = oxNew('Object_Seo');
        $this->assertFalse($oView->isEntrySuffixed());
    }

    /**
     * Testing Object_Seo::isSuffixSupported()
     *
     * @return null
     */
    public function isSuffixSupported()
    {
        $oView = oxNew('Object_Seo');
        $this->assertFalse($oView->isSuffixSupported());
    }

    /**
     * Testing Object_Seo::showCatSelect()
     *
     * @return null
     */
    public function showCatSelect()
    {
        $oView = oxNew('Object_Seo');
        $this->assertFalse($oView->showCatSelect());
    }

    /**
     * Testing Object_Seo::processParam( $sParam )
     *
     * @return null
     */
    public function testProcessParam()
    {
        $sParam = "param";

        $oView = oxNew('Object_Seo');
        $this->assertEquals($sParam, $oView->processParam($sParam));
    }

    /**
     * Testing Object_Seo::getEncoder()
     *
     * @return null
     */
    public function testGetEncoder()
    {
        $oView = oxNew('Object_Seo');
        $this->assertNull($oView->getEncoder());
    }

    /**
     * Testing Object_Seo::getEntryUri()
     *
     * @return null
     */
    public function testGetEntryUri()
    {
        $oView = oxNew('Object_Seo');
        $this->assertNull($oView->getEntryUri());
    }

    /**
     * Testing Object_Seo::getType()
     *
     * @return null
     */
    public function testGetType()
    {
        $oView = oxNew('Object_Seo');
        $this->assertNull($oView->getType());
    }

    /**
     * Testing Object_Seo::getStdUrl()
     *
     * @return null
     */
    public function testGetStdUrl()
    {
        $oView = oxNew('Object_Seo');
        $this->assertNull($oView->getStdUrl("anyid"));
    }

    /**
     * Object_Seo::GetEditLang() test case
     *
     * @return null
     */
    public function testGetEditLang()
    {
        // testing..
        $oView = $this->getProxyClass("Object_Seo");
        $oView->setNonPublicVar("_iEditLang", 999);
        $this->assertEquals(999, $oView->getEditLang());
    }

    /**
     * Testing Object_Seo::getAltSeoEntryId()
     *
     * @return null
     */
    public function testGetAltSeoEntryId()
    {
        $oView = oxNew('Object_Seo');
        $this->assertNull($oView->getAltSeoEntryId());
    }

    /**
     * Returns seo entry type
     *
     * @return string
     */
    public function testGetSeoEntryType()
    {
        $oView = $this->getMock(\OxidEsales\Eshop\Application\Controller\Admin\ObjectSeo::class, array("getType"));
        $oView->expects($this->once())->method('getType')->will($this->returnValue("testType"));
        $this->assertEquals("testType", $oView->getSeoEntryType());
    }

    /**
     * Object_Seo::Render() test case
     *
     * @return null
     */
    public function testRender()
    {
        // testing..
        $oView = oxNew('Object_Seo');
        $this->assertEquals('object_seo', $oView->render());
    }

    /**
     * Object_Seo::Save() test case
     *
     * @return null
     */
    public function testSave()
    {
        $this->setRequestParameter("aSeoData", array("oxseourl" => "testSeoUrl", "oxkeywords" => " testKeywords ", "oxdescription" => " testDescription ", "oxparams" => "testParams", "oxfixed" => 0));

        $oEncoder = $this->getMock(\OxidEsales\Eshop\Core\SeoEncoder::class, array("addSeoEntry"));
        $oEncoder->expects($this->once())->method("addSeoEntry")->with(
            $this->equalTo("objectId"),
            $this->equalTo(1),
            $this->equalTo(1),
            $this->equalTo("stdUrl"),
            $this->equalTo("testSeoUrl"),
            $this->equalTo("seoEntryType"),
            $this->equalTo(0),
            $this->equalTo("testKeywords"),
            $this->equalTo("testDescription"),
            $this->equalTo("param"),
            $this->equalTo(true),
            $this->equalTo("altSeoEntryId")
        );

        $oConfig = $this->getMock(\OxidEsales\Eshop\Core\Config::class, array("getShopId"));
        $oConfig->expects($this->once())->method("getShopId")->will($this->returnValue(1));

        // testing..
        $oView = $this->getMock(\OxidEsales\Eshop\Application\Controller\Admin\ObjectSeo::class, array("getEditObjectId", "getConfig", "getEncoder", "getEditLang", "getStdUrl", "getSeoEntryType", "processParam", "getAltSeoEntryId"), array(), '', false);
        $oView->expects($this->once())->method('getEditObjectId')->will($this->returnValue("objectId"));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Config::class, $oConfig);
        $oView->expects($this->once())->method('getEncoder')->will($this->returnValue($oEncoder));
        $oView->expects($this->once())->method('getStdUrl')->will($this->returnValue("stdUrl"));
        $oView->expects($this->once())->method('getEditLang')->will($this->returnValue(1));
        $oView->expects($this->once())->method('getSeoEntryType')->will($this->returnValue("seoEntryType"));
        $oView->expects($this->once())->method('processParam')->will($this->returnValue("param"));
        $oView->expects($this->once())->method('getAltSeoEntryId')->will($this->returnValue("altSeoEntryId"));
        $oView->save();
    }

    /**
     * Object_Seo::getEntryMetaData() test case
     *
     * @return null
     */
    public function testGetEntryMetaData()
    {
        $oEncoder = $this->getMock(\OxidEsales\Eshop\Core\SeoEncoder::class, array("getMetaData"));
        $oEncoder->expects($this->once())->method('getMetaData')->with($this->equalTo(1), $this->equalTo("MetaType"), $this->equalTo("shopid"), $this->equalTo(1))->will($this->returnValue("metaData"));

        $oConfig = $this->getMock(\OxidEsales\Eshop\Core\Config::class, array("getShopId"));
        $oConfig->expects($this->once())->method('getShopId')->will($this->returnValue("shopid"));

        $oView = $this->getMock(\OxidEsales\Eshop\Application\Controller\Admin\ObjectSeo::class, array("getEncoder", "getEditObjectId", "getConfig", "getEditLang"), array(), '', false);
        $oView->expects($this->once())->method('getEncoder')->will($this->returnValue($oEncoder));
        $oView->expects($this->once())->method('getEditObjectId')->will($this->returnValue(1));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Config::class, $oConfig);
        $oView->expects($this->once())->method('getEditLang')->will($this->returnValue(1));
        $this->assertEquals("metaData", $oView->getEntryMetaData("MetaType"));
    }

    /**
     * Object_Seo::getActCatType() test case
     *
     * @return null
     */
    public function testGetActCatType()
    {
        // testing..
        $oView = oxNew('Object_Seo');
        $this->assertFalse($oView->getActCatType());
    }
}
