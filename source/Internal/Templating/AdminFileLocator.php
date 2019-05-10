<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

use OxidEsales\Eshop\Core\Config;

class AdminFileLocator implements FileLocatorInterface
{
    /**
     * @var TemplateNameResolverInterface
     */
    private $templateNameResolver;

    /**
     * @var EngineInterface
     */
    private $templateEngine;

    /**
     * @var Config
     */
    private $context;

    public function __construct(
        Config $context,
        TemplateNameResolverInterface $templateNameResolver,
        EngineInterface $templateEngine)
    {
        $this->context = $context;
        $this->templateNameResolver = $templateNameResolver;
        $this->templateEngine = $templateEngine;
    }

    /**
     * Returns a full path for a given file name.
     *
     * @param string $name The file name to locate
     *
     * @return string The full path to the file
     */
    public function locate($name): string
    {
        $templateName = $this->templateNameResolver->resolve($name, $this->templateEngine->getDefaultFileExtension());
        return $this->context->getTemplatePath($templateName, true);
    }
}