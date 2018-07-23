<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Application;

use OxidEsales\Eshop\Core\Registry;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

/**
  *
 * @internal
 */
class ContainerFactory
{
    /**
     * @var self
     */
    private static $instance = null;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $symfonyContainer = null;

    /**
     * ContainerFactory constructor.
     *
     * Make the constructor private
     */
    private function __construct()
    {
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        if ($this->symfonyContainer === null) {
            $this->initializeContainer();
        }

        return $this->symfonyContainer;
    }

    /**
     * Reads the container definition again and writes
     * new cache file
     */
    public function resetContainer() {

        $cacheFilePath = $this->getCacheFilePath();
        $this->createAndCompileSymfonyContainer();
        $this->saveContainerToCache($cacheFilePath);

    }

    /**
     * Loads container from cache if available, otherwise
     * create the container from scratch.
     */
    private function initializeContainer()
    {
        $cacheFilePath = $this->getCacheFilePath();

        if (file_exists($cacheFilePath)) {
            $this->loadContainerFromCache($cacheFilePath);
        } else {
            $this->createAndCompileSymfonyContainer();
            $this->saveContainerToCache($cacheFilePath);
        }
    }

    /**
     * @param string $cachefile
     */
    private function loadContainerFromCache($cachefile)
    {
        include_once $cachefile;
        $this->symfonyContainer = new \ProjectServiceContainer();
    }

    /**
     * Builds the container from services.yaml and compiles it
     */
    private function createAndCompileSymfonyContainer()
    {
        $this->symfonyContainer = new ContainerBuilder();
        // This is hackish - but the only way to use the ContainerAwareEventDispatcher that
        // is expected by the RegisterListenersPass - so you need to create some cyclical
        // dependency. The factory method for the event dispatcher used *in* the container
        // provides exactly this instance created before building up the container.
        $this->symfonyContainer->addCompilerPass(new RegisterListenersPass());
        $loader = new YamlFileLoader($this->symfonyContainer, new FileLocator(__DIR__));
        $loader->load('services.yaml');
        try {
            $loader = new YamlFileLoader($this->symfonyContainer, new FileLocator($this->getShopSourcePath()));
            $loader->load('project.yaml');
        } catch (\Exception $e) {
            // pass
        }
        $this->symfonyContainer->compile();
    }

    /**
     * Dumps the compiled container to the cachefile.
     *
     * @param string $cachefile
     */
    private function saveContainerToCache($cachefile)
    {
        $dumper = new PhpDumper($this->symfonyContainer);
        file_put_contents($cachefile, $dumper->dump());
    }

    /**
     * @todo: move it to another place.
     *
     * @return string
     */
    private function getCacheFilePath()
    {
        $compileDir = Registry::getConfig()->getConfigParam('sCompileDir');

        return $compileDir . '/containercache.php';
    }

    /**
     * @return string
     */
    private function getShopSourcePath()
    {
        return Registry::getConfig()->getConfigParam('sShopDir');
    }

    /**
     * @return ContainerFactory
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ContainerFactory();
        }
        return self::$instance;
    }

}
