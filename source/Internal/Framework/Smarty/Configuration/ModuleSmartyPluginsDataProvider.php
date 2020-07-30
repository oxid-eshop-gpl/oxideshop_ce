<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;

class ModuleSmartyPluginsDataProvider implements SmartyPluginsDataProviderInterface
{
    /**
     * @var SmartyPluginsDataProviderInterface
     */
    private $dataProvider;

    /**
     * @var ShopAdapterInterface
     */
    private $shopAdapter;

    public function __construct(
        SmartyPluginsDataProviderInterface $dataProvider,
        ShopAdapterInterface $shopAdapter
    )
    {
        $this->dataProvider = $dataProvider;
        $this->shopAdapter = $shopAdapter;
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getPlugins(): array
    {
        $pluginsPaths = $this->dataProvider->getPlugins();
        $pluginsPaths = array_merge($this->getModuleSmartyPluginDirectories(), $pluginsPaths);
        return $pluginsPaths;
    }

    /**
     * @return array
     */
    private function getModuleSmartyPluginDirectories(): array
    {
        return $this->shopAdapter->getSmartyPluginDirectoriesFromCache();
    }
}
