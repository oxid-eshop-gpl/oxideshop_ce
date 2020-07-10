<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration;

use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Extension\ResourcePluginInterface;

class SmartyResourcesDataProvider implements SmartyResourcesDataProviderInterface
{
    /**
     * @var ResourcePluginInterface
     */
    private $resourcePlugin;

    public function __construct(ResourcePluginInterface $resourcePlugin)
    {
        $this->resourcePlugin = $resourcePlugin;
    }

    /**
     * Returns an array of resources.
     *
     * @return array
     */
    public function getResources(): array
    {
        return [
            'ox' => [
                $this->resourcePlugin,
                'getTemplate',
                'getTimestamp',
                'getSecure',
                'getTrusted'
            ]
        ];
    }
}
