<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\ModuleConfiguration\ProjectModuleConfiguration;

/**
 * @internal
 */
interface ConfigurationFactoryInterface
{
    /**
     * @return ConfigurationInterface
     */
    public function create(): ConfigurationInterface;
}