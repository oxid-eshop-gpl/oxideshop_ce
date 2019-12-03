<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Core;

use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Theme;
use OxidEsales\Eshop\Core\UtilsView;
use \stdClass;
use \oxRegistry;
use \oxTestModules;

class UtilsViewTest extends \OxidTestCase
{
    public function setUp()
    {
        parent::setUp();

        $theme = oxNew(Theme::class);
        $theme->load('azure');
        $theme->activate();
    }

    public function testGetTemplateDirsContainsAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $expectedTemplateDirs = $this->getTemplateDirsAzure();
        $utilsView = $this->getUtilsViewMockNotAdmin();

        $this->assertArraySubset($expectedTemplateDirs, $utilsView->getTemplateDirs());
    }

    public function testGetTemplateDirsOnlyAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $expectedTemplateDirs = $this->getTemplateDirsAzure();
        $utilsView = $this->getUtilsViewMockNotAdmin();

        $this->assertEquals($expectedTemplateDirs, $utilsView->getTemplateDirs());
    }

    public function testGetEditionTemplateDirsContainsAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $shopPath = $this->getShopPath();

        $dirs = [
            $shopPath . 'Application/views/azure/tpl/',
            $shopPath . 'out/azure/tpl/',
        ];

        $utilsView = $this->getUtilsViewMockNotAdmin();

        $this->assertArraySubset($dirs, $utilsView->getTemplateDirs());
    }

    public function testGetEditionTemplateDirsOnlyAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $shopPath = $this->getShopPath();

        $dirs = [
            $shopPath . 'Application/views/azure/tpl/',
            $shopPath . 'out/azure/tpl/',
        ];

        $utilsView = $this->getUtilsViewMockNotAdmin();

        $this->assertEquals($dirs, $utilsView->getTemplateDirs());
    }

    public function testGetEditionTemplateDirsForAdminContainsAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $shopPath = $this->getShopPath();

        $dirs = [
            $shopPath . 'Application/views/admin/tpl/',
        ];

        $utilsView = $this->getUtilsViewMockBeAdmin();

        $this->assertArraySubset($dirs, $utilsView->getTemplateDirs());
    }

    public function testGetEditionTemplateDirsForAdminOnlyAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $shopPath = $this->getShopPath();

        $dirs = [
            $shopPath . 'Application/views/admin/tpl/',
        ];

        $utilsView = $this->getUtilsViewMockBeAdmin();

        $this->assertEquals($dirs, $utilsView->getTemplateDirs());
    }

    public function testSetTemplateDirContainsAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $myConfig = $this->getConfig();
        $aDirs[] = "testDir1";
        $aDirs[] = "testDir2";
        $aDirs[] = $myConfig->getTemplateDir(false);
        $sDir = $myConfig->getOutDir(true) . $myConfig->getConfigParam('sTheme') . "/tpl/";
        if (!in_array($sDir, $aDirs)) {
            $aDirs[] = $sDir;
        }

        $sDir = $myConfig->getOutDir(true) . "azure/tpl/";
        if (!in_array($sDir, $aDirs)) {
            $aDirs[] = $sDir;
        }

        $utilsView = $this->getUtilsViewMockNotAdmin();
        $utilsView->setTemplateDir("testDir1");
        $utilsView->setTemplateDir("testDir2");
        $utilsView->setTemplateDir("testDir1");

        $this->assertArraySubset($aDirs, $utilsView->getTemplateDirs());
    }

    public function testSetTemplateDirOnlyAzure()
    {
        if ($this->getTestConfig()->getShopEdition() != 'CE') {
            $this->markTestSkipped('This test is for Community edition only.');
        }

        $myConfig = $this->getConfig();
        $aDirs[] = "testDir1";
        $aDirs[] = "testDir2";
        $aDirs[] = $myConfig->getTemplateDir(false);
        $sDir = $myConfig->getOutDir(true) . $myConfig->getConfigParam('sTheme') . "/tpl/";
        if (!in_array($sDir, $aDirs)) {
            $aDirs[] = $sDir;
        }

        $sDir = $myConfig->getOutDir(true) . "azure/tpl/";
        if (!in_array($sDir, $aDirs)) {
            $aDirs[] = $sDir;
        }

        $utilsView = $this->getUtilsViewMockNotAdmin();
        $utilsView->setTemplateDir("testDir1");
        $utilsView->setTemplateDir("testDir2");
        $utilsView->setTemplateDir("testDir1");

        $this->assertEquals($aDirs, $utilsView->getTemplateDirs());
    }

    public function testPassAllErrorsToView()
    {
        $aView = [];
        $aErrors[1][2] = serialize("foo");
        \OxidEsales\Eshop\Core\Registry::getUtilsView()->passAllErrorsToView($aView, $aErrors);
        $this->assertEquals($aView['Errors'][1][2], "foo");
    }

    public function testAddErrorToDisplayCustomDestinationFromParam()
    {
        $session = $this->getMock(\OxidEsales\Eshop\Core\Session::class, ['getId']);
        $session->expects($this->once())->method('getId')->will($this->returnValue(true));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Session::class, $session);

        $oxUtilsView = oxNew(\OxidEsales\Eshop\Core\UtilsView::class);
        $oxUtilsView->addErrorToDisplay("testMessage", false, true, "myDest");

        $aErrors = oxRegistry::getSession()->getVariable('Errors');
        $oEx = unserialize($aErrors['myDest'][0]);
        $this->assertEquals("testMessage", $oEx->getOxMessage());
        $this->assertNull(oxRegistry::getSession()->getVariable('ErrorController'));
    }

    public function testAddErrorToDisplayCustomDestinationFromPost()
    {
        $this->setRequestParameter('CustomError', 'myDest');
        $this->setRequestParameter('actcontrol', 'oxwminibasket');

        $session = $this->getMock(\OxidEsales\Eshop\Core\Session::class, ['getId']);
        $session->expects($this->once())->method('getId')->will($this->returnValue(true));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Session::class, $session);

        $oxUtilsView = oxNew(\OxidEsales\Eshop\Core\UtilsView::class);
        $oxUtilsView->addErrorToDisplay("testMessage", false, true, "");
        $aErrors = Registry::getSession()->getVariable('Errors');
        $oEx = unserialize($aErrors['myDest'][0]);
        $this->assertEquals("testMessage", $oEx->getOxMessage());
        $aErrorController = Registry::getSession()->getVariable('ErrorController');
        $this->assertEquals("oxwminibasket", $aErrorController['myDest']);
    }

    public function testAddErrorToDisplayDefaultDestination()
    {
        $this->setRequestParameter('actcontrol', 'start');
        $session = $this->getMock(\OxidEsales\Eshop\Core\Session::class, ['getId']);
        $session->expects($this->once())->method('getId')->will($this->returnValue(true));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Session::class, $session);

        $oxUtilsView = oxNew(\OxidEsales\Eshop\Core\UtilsView::class);
        $oxUtilsView->addErrorToDisplay("testMessage", false, true, "");
        $aErrors = Registry::getSession()->getVariable('Errors');
        $oEx = unserialize($aErrors['default'][0]);
        $this->assertEquals("testMessage", $oEx->getOxMessage());
        $aErrorController = Registry::getSession()->getVariable('ErrorController');
        $this->assertEquals("start", $aErrorController['default']);
    }

    public function testAddErrorToDisplayUsingExeptionObject()
    {
        $oTest = oxNew('oxException');
        $oTest->setMessage("testMessage");

        $session = $this->getMock(\OxidEsales\Eshop\Core\Session::class, ['getId']);
        $session->expects($this->once())->method('getId')->will($this->returnValue(true));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Session::class, $session);

        $oxUtilsView = oxNew(\OxidEsales\Eshop\Core\UtilsView::class);
        $oxUtilsView->addErrorToDisplay($oTest, false, false, "");

        $aErrors = Registry::getSession()->getVariable('Errors');
        $oEx = unserialize($aErrors['default'][0]);
        $this->assertEquals("testMessage", $oEx->getOxMessage());
    }

    public function testAddErrorToDisplayIfNotSet()
    {
        $session = $this->getMock(\OxidEsales\Eshop\Core\Session::class, ['getId']);
        $session->expects($this->once())->method('getId')->will($this->returnValue(true));
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Session::class, $session);

        $oxUtilsView = oxNew(\OxidEsales\Eshop\Core\UtilsView::class);
        $oxUtilsView->addErrorToDisplay(null, false, false, "");

        $aErrors = Registry::getSession()->getVariable('Errors');
        //$oEx = unserialize($aErrors['default'][0]);
        //$this->assertEquals("", $oEx->getOxMessage());
        $this->assertFalse(isset($aErrors['default'][0]));
        $this->assertNull(Registry::getSession()->getVariable('ErrorController'));
    }

    public function testAddErrorToDisplay_startsSessionIfNotStarted()
    {
        $session = $this->getMock(\OxidEsales\Eshop\Core\Session::class, ['getId', 'isHeaderSent', 'setForceNewSession', 'start']);
        $session->expects($this->once())->method('getId')->will($this->returnValue(false));
        $session->expects($this->once())->method('isHeaderSent')->will($this->returnValue(false));
        $session->expects($this->once())->method('setForceNewSession');
        $session->expects($this->once())->method('start');
        \OxidEsales\Eshop\Core\Registry::set(\OxidEsales\Eshop\Core\Session::class, $session);

        $oxUtilsView = oxNew(\OxidEsales\Eshop\Core\UtilsView::class);
        $oxUtilsView->addErrorToDisplay(null, false, false, "");
    }

    /**
     * Testing smarty processor
     */
    public function testGetRenderedContent()
    {
        $aData['shop'] = new stdClass();
        $aData['shop']->urlSeparator = '?';

        $oUtilsView = oxNew(UtilsView::class);
        $this->assertEquals('?', $oUtilsView->getRenderedContent('[{$shop->urlSeparator}]', $aData, time()));
    }

    /**
     * Testing smarty processor
     */
    public function testGetRenderedContentForDemoShop()
    {
        $aData['shop'] = new stdClass();
        $aData['shop']->urlSeparator = '?';

        $this->getConfig()->setConfigParam('blDemoShop', 1);

        $oUtilsView = oxNew(UtilsView::class);
        $this->assertEquals('[{$shop->urlSeparator}]', $oUtilsView->getRenderedContent('[{$shop->urlSeparator}]', $aData, time()));
    }

    /**
     * base test
     */
    public function testGetActiveModuleInfo()
    {
        oxTestModules::addFunction('oxModulelist', 'getActiveModuleInfo', '{ return true; }');
        $oUV = $this->getProxyClass('oxUtilsView');

        $this->assertTrue($oUV->UNITgetActiveModuleInfo());
    }

    /**
     * tests oxutilsView::getSmartyDir()
     */
    public function testGetSmartyDir()
    {
        $config = oxNew('oxConfig');

        $oUV = oxNew('oxUtilsView');
        Registry::set(Config::class, $config);

        $compileDirectory = $this->getCompileDirectory();
        $config->setConfigParam('sCompileDir', $compileDirectory);

        $sExp = $compileDirectory . "/smarty/";

        $this->assertSame($sExp, $oUV->getSmartyDir());
    }

    /**
     * @return array
     */
    private function getTemplateDirsAzure()
    {
        $config = $this->getConfig();
        $dirs = [];
        $dirs[] = $config->getTemplateDir(false);
        $dir = $config->getOutDir(true) . $config->getConfigParam('sTheme') . "/tpl/";
        if (!in_array($dir, $dirs)) {
            $dirs[] = $dir;
        }
        $dir = $config->getOutDir(true) . "azure/tpl/";
        if (!in_array($dir, $dirs)) {
            $dirs[] = $dir;
        }
        return $dirs;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getUtilsViewMockNotAdmin()
    {
        $utilsView = $this->getMock(\OxidEsales\Eshop\Core\UtilsView::class, ["isAdmin"]);
        $utilsView->expects($this->any())->method('isAdmin')->will($this->returnValue(false));
        return $utilsView;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getUtilsViewMockBeAdmin()
    {
        $utilsView = $this->getMock(\OxidEsales\Eshop\Core\UtilsView::class, ["isAdmin"]);
        $utilsView->expects($this->any())->method('isAdmin')->will($this->returnValue(true));
        return $utilsView;
    }

    /**
     * @return string
     */
    private function getShopPath()
    {
        $config = $this->getConfig();
        $shopPath = rtrim($config->getConfigParam('sShopDir'), '/') . '/';
        return $shopPath;
    }

    /**
     * @return string
     */
    private function getCompileDirectory()
    {
        $oVfsStreamWrapper = $this->getVfsStreamWrapper();
        $oVfsStreamWrapper->createStructure(['tmp_directory' => []]);
        $compileDirectory = $oVfsStreamWrapper->getRootPath() . 'tmp_directory';
        return $compileDirectory;
    }
}
