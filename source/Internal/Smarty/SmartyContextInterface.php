<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Smarty;

/**
 * Interface SmartyContextInterface
 * @package OxidEsales\EshopCommunity\Internal\Smarty
 */
interface SmartyContextInterface
{
    /**
     * @return bool
     */
    public function getTemplateEngineDebugMode(): bool;

    /**
     * @return bool
     */
    public function showTemplateNames(): bool;

    /**
     * @return bool
     */
    public function getTemplateSecurityMode(): bool;

    /**
     * @return string
     */
    public function getTemplateCompileDirectory(): string;

    /**
     * @return array
     */
    public function getTemplateDirectories(): array;

    /**
     * @return string
     */
    public function getTemplateCompileId(): string;

    /**
     * @return bool
     */
    public function getTemplateCompileCheckMode(): bool;

    /**
     * @return array
     */
    public function getModuleTemplatePluginDirectories(): array;

    /**
     * @return array
     */
    public function getShopTemplatePluginDirectories(): array;

    /**
     * @return int
     */
    public function getTemplatePhpHandlingMode(): int;

    /**
     * @return string
     */
    public function getShopTemplatePluginDirectory(): string;

    /**
     * @param string $templateName
     *
     * @return string
     */
    public function getTemplatePath($templateName): string;
}
