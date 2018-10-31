<?php declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\ProjectDIConfig\Service;

use OxidEsales\EshopCommunity\Internal\ProjectDIConfig\Dao\ProjectYamlDaoInterface;
use OxidEsales\EshopCommunity\Internal\ProjectDIConfig\DataObject\DIConfigWrapper;
use OxidEsales\EshopCommunity\Internal\ProjectDIConfig\DataObject\DIServiceWrapper;

/**
 * @internal
 */
class ShopActivationService implements ShopActivationServiceInterface
{

    /**
     * @var ProjectYamlDaoInterface $dao
     */
    public $dao;

    /**
     * ShopAwareServiceActivationService constructor.
     *
     * @param ProjectYamlDaoInterface $dao
     */
    public function __construct(ProjectYamlDaoInterface $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param string $moduleDir
     * @param array  $shopIds
     * @return void
     */
    public function activateServicesForShops(string $moduleDir, array $shopIds)
    {
        $moduleConfigFile = $moduleDir . DIRECTORY_SEPARATOR . 'services.yaml';
        $moduleConfig = $this->getModuleConfig($moduleConfigFile);
        if ($moduleConfig === null) {
            return;
        }

        $projectConfig = $this->dao->loadProjectConfigFile();
        $projectConfig->addImport($moduleConfigFile);

        /** @var DIServiceWrapper $service */
        foreach ($moduleConfig->getServices() as $service) {
            if (! $service->isShopAware()) {
                continue;
            }
            if ($projectConfig->hasService($service->getKey())) {
                $service = $projectConfig->getService($service->getKey());
            }
            $service->addActiveShops($shopIds);
            $projectConfig->addOrUpdateService($service);
        }

        $this->dao->saveProjectConfigFile($projectConfig);
    }


    /**
     * @param string $moduleDir
     * @param array  $shopIds
     * @return void
     */
    public function deactivateServicesForShops(string $moduleDir, array $shopIds)
    {
        $moduleConfigFile = $moduleDir . DIRECTORY_SEPARATOR . 'services.yaml';
        $moduleConfig = $this->getModuleConfig($moduleConfigFile);
        if ($moduleConfig === null) {
            return;
        }
        $projectConfig = $this->dao->loadProjectConfigFile();

        $removeImport = false;
        /** @var DIServiceWrapper $service */
        foreach ($moduleConfig->getServices() as $service) {
            if (! $service->isShopAware()) {
                continue;
            }
            $service = $projectConfig->getService($service->getKey());
            $remainingShops = $service->removeActiveShops($shopIds);
            if (count($remainingShops) == 0) {
                $removeImport = true;
            }
            $projectConfig->addOrUpdateService($service);
        }
        if ($removeImport) {
            $projectConfig->removeImport($moduleConfigFile);
        }
        $this->dao->saveProjectConfigFile($projectConfig);
    }

    /**
     * @param string $moduleConfigFile
     *
     * @return DIConfigWrapper
     */
    private function getModuleConfig(string $moduleConfigFile): DIConfigWrapper
    {

        if (! file_exists($moduleConfigFile)) {
            // Nothing to do. The module does not define services
            return null;
        }
        return $this->dao->loadDIConfigFile($moduleConfigFile);
    }
}
