<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Transition\Smarty\Configuration;

use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration\SmartyResourcesDataProvider;
use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Extension\ResourcePluginInterface;

class SmartyResourcesDataProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSmartyResources()
    {
        $pluginMock = $this->getMockBuilder(ResourcePluginInterface::class)->getMock();
        $datProvider = new SmartyResourcesDataProvider($pluginMock);

        $settings = ['ox' => [
            $pluginMock,
            'getTemplate',
            'getTimestamp',
            'getSecure',
            'getTrusted'
        ]
        ];

        $this->assertEquals($settings, $datProvider->getResources());
    }
}
