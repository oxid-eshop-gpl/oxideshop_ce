<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Loader;

use OxidEsales\Eshop\Core\Config;
use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Templating\TemplateLoaderInterface;
use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader as TwigLoader;

/**
 * Class ContentSnippetLoader
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class FilesystemLoader extends TwigLoader
{

    /** @var Config */
    private $config;

    /** @var TemplateLoaderInterface */
    private $loader;

    /** @var TemplateLoaderInterface */
    private $adminLoader;

    /**
     * FilesystemLoader constructor.
     *
     * @param array                   $paths
     * @param string|null             $rootPath
     * @param TemplateLoaderInterface $loader
     * @param TemplateLoaderInterface $adminLoader
     */
    public function __construct(
        $paths = [],
        string $rootPath = null,
        TemplateLoaderInterface $loader = null,
        TemplateLoaderInterface $adminLoader = null
    )
    {
        parent::__construct($paths, $rootPath);

        $this->config = Registry::getConfig();
        $this->loader = $loader;
        $this->adminLoader = $adminLoader;
    }

    /**
     * @param string $name
     * @param bool   $throw
     *
     * @return string|null
     */
    public function findTemplate($name, $throw = true)
    {
        try {
            $template = parent::findTemplate($name, $throw);

            if ($template) {
                return $template;
            }
        } catch (LoaderError $error) {
        }

        if ($this->config->isAdmin()) {
            $template = $this->adminLoader->getPath($name);
        } else {
            $template = $this->loader->getPath($name);
        }

        if (!$template && isset($error)) {
            throw $error;
        } else {
            return $template;
        }
    }
}
