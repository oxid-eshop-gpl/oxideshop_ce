<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ModuleConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\CacheClearerInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;

class ShopModuleCacheService implements ModuleCacheServiceInterface
{

    /**
     * @var ShopAdapterInterface
     */
    private $shopAdapter;

    /**
     * @var CacheClearerInterface
     */
    private $cacheClearer;

    /**
     * @var ModuleConfigurationDaoBridgeInterface
     */
    private $configurationDaoBridge;

    /**
     * ShopModuleCacheService constructor.
     *
     * @param ShopAdapterInterface                  $shopAdapter
     * @param CacheClearerInterface                 $cacheClearer
     * @param ModuleConfigurationDaoBridgeInterface $configurationDaoBridge
     */
    public function __construct(
        ShopAdapterInterface $shopAdapter,
        CacheClearerInterface $cacheClearer,
        ModuleConfigurationDaoBridgeInterface $configurationDaoBridge
    ) {
        $this->shopAdapter = $shopAdapter;
        $this->cacheClearer = $cacheClearer;
        $this->configurationDaoBridge = $configurationDaoBridge;
    }

    /**
     * Invalidate all module related cache items for a given module and a given shop
     *
     * @param string $moduleId
     * @param int    $shopId
     */
    public function invalidateModuleCache(string $moduleId, int $shopId)
    {
        $this->shopAdapter->invalidateModuleCache($moduleId);
        $this->invalidateTemplateCache($moduleId);
    }

    /**
     * @param string $moduleId
     */
    private function invalidateTemplateCache(string $moduleId): void
    {
        $configuration = $this->configurationDaoBridge->get($moduleId);
        if ($configuration->hasTemplates()) {
            $this->cacheClearer->clear($this->getTemplates($configuration));
        }
    }

    /**
     * @param ModuleConfiguration $configuration
     *
     * @return array
     */
    private function getTemplates(ModuleConfiguration $configuration): array
    {
        $templates = [];

        foreach ($configuration->getTemplates() as $template) {
            $templates[$template->getTemplateKey()] = $template->getTemplateKey();
        }

        return $templates;
    }
}
