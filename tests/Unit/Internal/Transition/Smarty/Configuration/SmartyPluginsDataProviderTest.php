<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Transition\Smarty\Configuration;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Path\ModulePathResolverInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\State\ModuleStateServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration\SmartyPluginsDataProvider;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;

class SmartyPluginsDataProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testGetConfigurationWithSecuritySettingsOff()
    {
        $contextMock = $this->getContextMock();

        $dataProvider = new SmartyPluginsDataProvider($contextMock, $this->getShopConfigurationDaoMock(), $this->getStateServiceMock(), $this->getPathResolverMock());

        $settings = ['testModuleDir', 'testShopPath/Core/Smarty/Plugin'];

        $this->assertEquals($settings, $dataProvider->getPlugins());
    }

    private function getContextMock(): ContextInterface
    {
        $contextMock = $this
            ->getMockBuilder(ContextInterface::class)
            ->getMock();

        $contextMock
            ->method('getCurrentShopId')
            ->willReturn(1);

        return $contextMock;
    }

    private function getShopConfigurationDaoMock()
    {
        $moduleConfiguration = $this->prophesize(ModuleConfiguration::class);
        $moduleConfiguration->getId()->willReturn('testId');
        $moduleConfiguration->getSmartyPluginDirectories()->willReturn(['testModuleDir']);
        $shopConfiguration = $this->prophesize(ShopConfiguration::class);
        $shopConfiguration->getModuleConfigurations()->willReturn([$moduleConfiguration->reveal()]);
        $dao = $this->prophesize(ShopConfigurationDaoBridgeInterface::class);
        $dao->get()->willReturn($shopConfiguration->reveal());
        return $dao->reveal();
    }

    private function getStateServiceMock()
    {
        $stateService = $this->prophesize(ModuleStateServiceInterface::class);
        $stateService->isActive('testId', 1)->willReturn(true);
        return $stateService->reveal();
    }

    private function getPathResolverMock()
    {
        $pathResolver = $this->prophesize(ModulePathResolverInterface::class);
        $pathResolver->getFullModulePathFromConfiguration('testId', 1)->willReturn('testModuleDir');
        return $pathResolver;
    }
}
