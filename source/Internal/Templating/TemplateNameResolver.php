<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

/**
 * Class TemplateNameResolver
 */
class TemplateNameResolver implements TemplateNameResolverInterface
{
    /**
     * @param string $name
     * @param string $fileExtension
     *
     * @return string
     */
    public function resolve(string $name, string $fileExtension) : string
    {
        if ($name !== '') {
            $name = $name . '.' . $fileExtension;
        }
        return $name;
    }
}
