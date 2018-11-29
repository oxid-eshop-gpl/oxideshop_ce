<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Smarty;

use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Smarty\SmartyContext;

class SmartyContextTest extends \PHPUnit\Framework\TestCase
{
    public function getTemplateEngineDebugModeDataProvider()
    {
        return [
            [1, true],
            [3, true],
            [4, true],
            [6, false],
            ['two', false],
            ['5', false]
        ];
    }

    /**
     * @param mixed $configValue
     * @param bool  $debugMode
     *
     * @dataProvider getTemplateEngineDebugModeDataProvider
     */
    public function testGetTemplateEngineDebugMode($configValue, $debugMode)
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('iDebug')
            ->will($this->returnValue($configValue));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame($debugMode, $smartyContext->getTemplateEngineDebugMode());
    }

    public function showTemplateNamesDataProvider()
    {
        return [
            [8, false, true],
            [8, true, false],
            [5, false, false],
            [5, false, false],
        ];
    }

    /**
     * @param mixed $configValue
     * @param bool  $adminMode
     * @param bool  $result
     *
     * @dataProvider showTemplateNamesDataProvider
     */
    public function testShowTemplateNames($configValue, $adminMode, $result)
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('iDebug')
            ->will($this->returnValue($configValue));
        $config->method('isAdmin')
            ->will($this->returnValue($adminMode));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame($result, $smartyContext->showTemplateNames());
    }

    public function testGetTemplateSecurityMode()
    {
        $config = $this->getConfigMock();
        $config->method('isDemoShop')
            ->will($this->returnValue(true));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame(true, $smartyContext->getTemplateSecurityMode());
    }

    public function testGetTemplateCompileCheckMode()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('blCheckTemplates')
            ->will($this->returnValue(true));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame(true, $smartyContext->getTemplateCompileCheckMode());
    }

    public function testGetTemplatePhpHandlingMode()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('iSmartyPhpHandling')
            ->will($this->returnValue(true));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame(true, $smartyContext->getTemplatePhpHandlingMode());
    }

    public function testGetShopTemplatePluginDirectory()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('sCoreDir')
            ->will($this->returnValue('CoreDir/'));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame('CoreDir/Smarty/Plugin', $smartyContext->getShopTemplatePluginDirectory());
    }

    public function testGetTemplatePath()
    {
        $config = $this->getConfigMock();
        $config->method('isAdmin')
            ->will($this->returnValue(false));
        $config->method('getTemplatePath')
            ->with('testTemplate', false)
            ->will($this->returnValue('templatePath'));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame('templatePath', $smartyContext->getTemplatePath('testTemplate'));
    }

    public function testGetTemplateCompileDirectory()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getSmartyDir')
        ->will($this->returnValue('testCompileDir'));

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame('testCompileDir', $smartyContext->getTemplateCompileDirectory());
    }

    public function testGetTemplateDirectories()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getTemplateDirs')
            ->will($this->returnValue('testTemplateDir'));

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame('testTemplateDir', $smartyContext->getTemplateDirectories());
    }

    public function testGetTemplateCompileId()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getTemplateCompileId')
            ->will($this->returnValue('testCompileId'));

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame('testCompileId', $smartyContext->getTemplateCompileId());
    }

    public function testGetModuleTemplatePluginDirectories()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getModuleSmartyPluginDirectories')
            ->will($this->returnValue(['testModuleDir']));

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame(['testModuleDir'], $smartyContext->getModuleTemplatePluginDirectories());
    }

    public function testGetShopTemplatePluginDirectories()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getShopSmartyPluginDirectories')
            ->will($this->returnValue(['testShopDir']));

        $smartyContext = new SmartyContext($config, $utilsView);
        $this->assertSame(['testShopDir'], $smartyContext->getShopTemplatePluginDirectories());
    }

    private function getConfigMock()
    {
        $configMock = $this
            ->getMockBuilder(Config::class)
            ->getMock();

        return $configMock;
    }

    private function getUtilsViewMock()
    {
        $utilsViewMock = $this
            ->getMockBuilder(UtilsView::class)
            ->getMock();

        return $utilsViewMock;
    }
}