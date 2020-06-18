<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Transition\Smarty;

use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration\SmartyPluginsDataProviderInterface;
use OxidEsales\EshopCommunity\Tests\Integration\Internal\ContainerTrait;
use OxidEsales\Facts\Facts;
use PHPUnit\Framework\TestCase;

class SmartyPluginsDataProviderTest extends TestCase
{
    use ContainerTrait;

    public function testGetPlugins()
    {
        $dataProvider = $this->get(SmartyPluginsDataProviderInterface::class);

        $pluginDirectories = $dataProvider->getPlugins();
        $shopPluginDirectory = (new Facts())->getCommunityEditionSourcePath() . '/Core/Smarty/Plugin';

        $this->assertContains($shopPluginDirectory, $pluginDirectories);
        $this->assertFileExists($shopPluginDirectory);
    }
}
