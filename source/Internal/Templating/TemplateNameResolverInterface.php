<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

/**
 * Interface TemplateNameResolverInterface
 */
interface TemplateNameResolverInterface
{
    /**
     * @param string $name
     * @param string $fileExtension
     *
     * @return string
     */
    public function resolve(string $name, string $fileExtension): string;
}
