<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Transition\Smarty;

use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Framework\Smarty\SmartyContext;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\BasicContextStub;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\ContextStub;

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

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
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

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame($result, $smartyContext->showTemplateNames());
    }

    public function testGetTemplateSecurityMode()
    {
        $config = $this->getConfigMock();
        $config->method('isDemoShop')
            ->will($this->returnValue(true));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame(true, $smartyContext->getTemplateSecurityMode());
    }

    public function testGetTemplateCompileCheckMode()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('blCheckTemplates')
            ->will($this->returnValue(true));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame(true, $smartyContext->getTemplateCompileCheckMode());
    }

    public function testGetTemplateCompileCheckModeInProductiveMode()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('blCheckTemplates')
            ->will($this->returnValue(true));
        $config->method('isProductiveMode')
            ->will($this->returnValue(true));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertFalse($smartyContext->getTemplateCompileCheckMode());
    }

    public function testGetTemplatePhpHandlingMode()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('iSmartyPhpHandling')
            ->will($this->returnValue(1));

        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame(1, $smartyContext->getTemplatePhpHandlingMode());
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

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame('templatePath', $smartyContext->getTemplatePath('testTemplate'));
    }

    public function testGetTemplateCompileDirectory()
    {
        $config = $this->getConfigMock();
        $config->method('getConfigParam')
            ->with('sCompileDir', false)
            ->will($this->returnValue('testCompileDir'));
        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame('testCompileDir' . '/smarty', $smartyContext->getTemplateCompileDirectory());
    }

    public function testGetTemplateDirectories()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getTemplateDirs')
            ->will($this->returnValue(['testTemplateDir']));

        $smartyContext = new SmartyContext(new ContextStub(), $config, $utilsView);
        $this->assertSame(['testTemplateDir'], $smartyContext->getTemplateDirectories());
    }

    public function testGetTemplateCompileId()
    {
        $templateDirectories = ['testCompileDir'];
        $shopId = 1;
        $context = new ContextStub();
        $context->setCurrentShopId(1);
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $utilsView->method('getTemplateDirs')
            ->will($this->returnValue($templateDirectories));

        $smartyContext = new SmartyContext($context, $config, $utilsView);
        ;
        $this->assertSame(md5(reset($templateDirectories) . '__' . $shopId), $smartyContext->getTemplateCompileId());
    }

    public function testGetSourcePath()
    {
        $config = $this->getConfigMock();
        $utilsView = $this->getUtilsViewMock();
        $basicContext = new ContextStub();
        $basicContext->setSourcePath('testSourcePath');

        $smartyContext = new SmartyContext($basicContext, $config, $utilsView);
        $this->assertSame('testSourcePath', $smartyContext->getSourcePath());
    }

    /**
     * @return Config
     */
    private function getConfigMock()
    {
        $configMock = $this
            ->getMockBuilder(Config::class)
            ->getMock();

        return $configMock;
    }

    /**
     * @return UtilsView
     */
    private function getUtilsViewMock()
    {
        $utilsViewMock = $this
            ->getMockBuilder(UtilsView::class)
            ->getMock();

        return $utilsViewMock;
    }
}
