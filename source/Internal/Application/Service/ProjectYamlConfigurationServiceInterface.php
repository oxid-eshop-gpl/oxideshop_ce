<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 09.07.18
 * Time: 10:08
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Service;

interface ProjectYamlConfigurationServiceInterface
{

    /**
     * Adds the services.yaml file from a directory to the imports
     * section of the project.yaml. The parameter is the directory
     * where there is a services.yaml file. If this directory or
     * the services.yaml file do not exist, an Exception is thrown.
     *
     * In the project.yaml file the real path of the file is written.
     *
     * @throws \Exception
     *
     * @param $importPath
     */
    public function addImport($importPath);

    /**
     * Removes a services.yaml file from imports.
     *
     * If it is an already deleted file, you need to provide the exact
     * directory like it is written in the project.yaml file (without
     * trailing directory separator) to remove it
     * from the project file because we won't sanitize the directory
     * path.
     *
     * @param $importPath
     */
    public function removeImport($importPath);

    /**
     * Loads the project specific yaml file for service definitions
     * and extracts the information about the active shops for a
     * certain definition.
     *
     * @param $subscriberKey
     *
     * @return array
     */
    public function getActiveShopsForEventSubscriber($subscriberKey);

    /**
     * Finds all service ids for event subscribers in a module
     * directory.
     *
     * @param $moduleDir
     *
     * @return array
     */
    public function findModuleEventSubscribers($moduleDir);

    /**
     * @param string $modulePath
     * @param array  $shopIds
     */
    public function addActiveShopsToEventSubscribers($modulePath, array $shopIds);

    /**
     * @param string $modulePath
     * @param array  $shopIds
     */
    public function removeActiveShopsFromEventSubscribers($modulePath, array $shopIds);
}