<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Modules;

use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Install\DataObject\OxidEshopPackage;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Install\Service\ModuleInstallerInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridgeInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Base class for module integration tests.
 *
 * @group module
 */
abstract class BaseModuleTestCase extends \OxidEsales\TestingLibrary\UnitTestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * Ensure a clean environment before each test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->container = ContainerFactory::getInstance()->getContainer();

        $environment = new Environment();
        $environment->clean();
    }

    protected function installAndActivateModule(string $moduleId, int $shopId = 1): void
    {
        $installService = $this->container->get(ModuleInstallerInterface::class);
        $package = new OxidEshopPackage(__DIR__ . '/TestData/modules/' . $moduleId);
        $installService->install($package);

        $activationService = $this->container->get(ModuleActivationBridgeInterface::class);
        $activationService->activate($moduleId, $shopId);
    }

    /**
     * Deactivates module.
     *
     * @param Module $module
     * @param null   $moduleId
     * @param int    $shopId
     *
     * @throws \Exception
     */
    protected function deactivateModule(Module $module, $moduleId = null, int $shopId = 1): void
    {
        if (!$moduleId) {
            $moduleId = $module->getId();
        }

        $activationService = $this->container->get(ModuleActivationBridgeInterface::class);

        $activationService->deactivate($moduleId, $shopId);
    }

    /**
     * Runs all asserts
     *
     * @param array $expectedResult
     */
    protected function runAsserts(array $expectedResult): void
    {
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();

        $validator = new Validator($config);

        if (isset($expectedResult['blocks'])) {
            $this->assertTrue($validator->checkBlocks($expectedResult['blocks']), 'Blocks do not match expectations');
        }

        if (isset($expectedResult['extend'])) {
            $this->assertEquals(
                $expectedResult['extend'],
                $config->getConfigParam('aModules'),
                'Extensions do not match expectations'
            );
        }

        if (isset($expectedResult['controllers'])) {
            $this->assertTrue($validator->checkControllers($expectedResult['controllers']), 'Controllers do not match expectations');
        }

        if (isset($expectedResult['settings'])) {
            $this->assertTrue($validator->checkConfigAmount($expectedResult['settings']), 'Configs do not match expectations');
        }

        if (isset($expectedResult['settings_values'])) {
            $this->assertTrue(
                $validator->checkConfigValues($expectedResult['settings_values']),
                'Config values does not match expectations'
            );
        }
    }
}
