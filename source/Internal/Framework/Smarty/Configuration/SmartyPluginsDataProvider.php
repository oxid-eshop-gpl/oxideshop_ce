<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;

class SmartyPluginsDataProvider implements SmartyPluginsDataProviderInterface
{
    /**
     * @var ContextInterface
     */
    private $context;

    public function __construct(
        ContextInterface $context
    )
    {
        $this->context = $context;
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getPlugins(): array
    {
        return [$this->getShopSmartyPluginDirectory()];
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function getShopSmartyPluginDirectory(): string
    {
        return $this->getEditionsRootPaths() . DIRECTORY_SEPARATOR .
            'Internal' . DIRECTORY_SEPARATOR .
            'Framework' . DIRECTORY_SEPARATOR .
            'Smarty' . DIRECTORY_SEPARATOR .
            'Plugin';
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function getEditionsRootPaths(): string
    {
        return $this->context->getCommunityEditionSourcePath();
    }
}
