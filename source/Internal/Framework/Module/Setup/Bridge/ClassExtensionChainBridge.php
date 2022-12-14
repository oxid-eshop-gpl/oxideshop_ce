<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Service\ExtensionChainServiceInterface;

class ClassExtensionChainBridge implements ClassExtensionChainBridgeInterface
{
    public function __construct(private ExtensionChainServiceInterface $classExtensionChainService)
    {
    }

    /**
     * @param int $shopId
     */
    public function updateChain(int $shopId)
    {
        $this->classExtensionChainService->updateChain($shopId);
        Registry::getConfig()->reinitialize();
    }
}
