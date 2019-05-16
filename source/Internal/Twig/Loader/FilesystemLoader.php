<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Loader;

use OxidEsales\Eshop\Core\Config;
use OxidEsales\EshopCommunity\Core\Registry;
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

    /**
     * FilesystemLoader constructor.
     *
     * @param array       $paths
     * @param string|null $rootPath
     */
    public function __construct($paths = [], string $rootPath = null)
    {
        parent::__construct($paths, $rootPath);

        $this->config = Registry::getConfig();
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
        } catch (LoaderError $error) {};

        $template = $this->config->getTemplatePath($name, $this->config->isAdmin());

        if (!$template && isset($error)) {
            throw $error;
        } else {
            return $template;
        }
    }
}
