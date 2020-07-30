<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache;

/**
 * CacheClearerInterface.
 */
interface CacheClearerInterface
{
    /**
     * @param array $cache
     */
    public function clear(array $cache): void;
}
