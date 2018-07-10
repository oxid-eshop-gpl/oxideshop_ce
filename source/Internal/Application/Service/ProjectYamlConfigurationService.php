<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 03.07.18
 * Time: 11:49
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Service;

use OxidEsales\EshopCommunity\Internal\Utility\ContextInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

class ProjectYamlConfigurationService implements ProjectYamlConfigurationServiceInterface
{

    const PROJECT_FILE_NAME = 'project.yaml';
    const SERVICES_FILE_NAME = 'services.yaml';

    const IMPORTS_SECTION = 'imports';
    const SERVICES_SECTION = 'services';
    const CALLS_SECTION = 'calls';
    const RESOURCE_KEY = 'resource';
    const EVENT_SUBSCRIBER_TAG = 'kernel.event_subscriber';

    const SET_ACTIVE_SHOPS_METHOD = 'setActiveShops';
    const SET_ACTIVE_PARAMETERS = [[]];
    const SET_CONTEXT_METHOD = 'setContext';
    const SET_CONTEXT_PARAMETERS = ['@OxidEsales\EshopCommunity\Internal\Utility\ContextInterface'];

    /**
     * @var ContextInterface $context
     */
    private $context;

    public function __construct(ContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * Adds the services.yaml file from a directory to the imports
     * section of the project.yaml. The parameter is the directory
     * where there is a services.yaml file. If this directory or
     * the services.yaml file do not exist, an Exception is thrown.
     * 
     * In the project.yaml file the real path of the file is written.
     * 
     * @throws \Exception
     * @param $importPath
     */
    public function addImport($importPath)
    {

        $projectYaml = $this->readProjectFile();

        $projectYaml = $this->addImportSectionIfMissing($projectYaml);

        $normalizedFile = $this->getNormalizedServicesFile($importPath);

        if (key_exists(self::IMPORTS_SECTION, $projectYaml)
            && ! is_null($projectYaml[self::IMPORTS_SECTION])) {
            foreach ($projectYaml[self::IMPORTS_SECTION] as $import) {
                if ($import[self::RESOURCE_KEY] == $normalizedFile) {
                    return; // File is already imported
                };
            }
        }

        $projectYaml[self::IMPORTS_SECTION][] = [self::RESOURCE_KEY => $normalizedFile];

        $this->writeProjectFile($projectYaml);

    }

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
    public function removeImport($importPath)
    {
        $projectYaml = $this->readProjectFile();

        try {
            $normalizedFile = $this->getNormalizedServicesFile($importPath);
        } catch (\Exception $e) {
            $normalizedFile = $importPath . DIRECTORY_SEPARATOR . self::SERVICES_FILE_NAME;
        }

        $imports = [];
        if (key_exists(self::IMPORTS_SECTION, $projectYaml)
            && ! is_null($projectYaml[self::IMPORTS_SECTION])) {
            foreach ($projectYaml[self::IMPORTS_SECTION] as $import) {
                if ($import[self::RESOURCE_KEY] != $normalizedFile) {
                    $imports[] = $import;
                };
            }
        }

        $projectYaml[self::IMPORTS_SECTION] = $imports;

        $this->writeProjectFile($projectYaml);

    }

    /**
     * Returns the normalized path to the existing services.yaml
     * file in the given directory as parameter. It the file is
     * not found, an exception is thrown.
     * 
     * @param $importPath
     *
     * @return string
     * @throws \Exception
     */
    private function getNormalizedServicesFile($importPath) {

        $servicesYaml = $importPath . DIRECTORY_SEPARATOR . self::SERVICES_FILE_NAME;
        $normalizedFile = realpath($servicesYaml);
        if (! $normalizedFile) {
            throw new \Exception("Import file $servicesYaml does not exist!");
        }
        return $normalizedFile;
    }

    /**
     * Loads the project specific yaml file for service definitions
     * and extracts the information about the active shops for a
     * certain definition.
     *
     * @param $subscriberKey
     *
     * @return array
     */
    public function getActiveShopsForEventSubscriber($subscriberKey)
    {
        $definition = $this->getSymfonyEventSubscriberDefinition($subscriberKey);

        foreach ($definition->getMethodCalls() as $call) {
            if ($call[0] == self::SET_ACTIVE_SHOPS_METHOD) {
                return $call[1][0];
            }
        }

        return [];
    }

    /**
     * Finds all service ids for event subscribers in a module
     * directory.
     *
     * @param $moduleDir
     *
     * @return array
     */
    public function findModuleEventSubscribers($moduleDir)
    {

        $symfonyContainer = new ContainerBuilder();
        $loader = new YamlFileLoader($symfonyContainer, new FileLocator($moduleDir));
        $loader->load(self::SERVICES_FILE_NAME);

        $keys = [];

        foreach ($symfonyContainer->getDefinitions() as $serviceKey => $serviceDefinition) {
            if ($serviceDefinition->getTag(self::EVENT_SUBSCRIBER_TAG)) {
                $keys[] = $serviceKey;
            };
        }

        return $keys;
    }

    /**
     * @param string $modulePath
     * @param array  $shopIds
     */
    public function addActiveShopsToEventSubscribers($modulePath, array $shopIds)
    {

        $originalEntries = $this->getSubscriberEntries($modulePath);

        $projectYaml = $this->readProjectFile();

        if (array_key_exists(self::SERVICES_SECTION, $projectYaml)) {
            $configuredServices = $projectYaml[self::SERVICES_SECTION];
        }
        else {
            $configuredServices = [];
        }

        foreach ($originalEntries as $name => $fields) {

            if (array_key_exists($name, $configuredServices)) {
                $configuredServices[$name] = $this->addShopIdsToEntry($configuredServices[$name], $shopIds);
            } else {
                $configuredServices[$name] = $this->addShopIdsToEntry($fields, $shopIds);
            }
        }

        $projectYaml[self::SERVICES_SECTION] = $configuredServices;

        $this->writeProjectFile($projectYaml);

    }

    /**
     * @param string $modulePath
     * @param array  $shopIds
     */
    public function removeActiveShopsFromEventSubscribers($modulePath, array $shopIds)
    {

        $originalEntries = $this->getSubscriberEntries($modulePath);

        $projectYaml = $this->readProjectFile();

        if (! array_key_exists(self::SERVICES_SECTION, $projectYaml)) {
            return;
        }

        $services = $projectYaml[self::SERVICES_SECTION];

        foreach ($originalEntries as $name => $fields) {

            if (array_key_exists($name, $services)) {
                $services[$name] = $this->removeShopFromEntry($services[$name], $shopIds);
            }
        }

        $projectYaml[self::SERVICES_SECTION] = $services;

        $this->writeProjectFile($projectYaml);

    }

    private function removeShopFromEntry($entry, $shopIds) {

        if (! array_key_exists(self::CALLS_SECTION, $entry)) {
            return $entry;
        }
        for($i = 0; $i < sizeof($entry[self::CALLS_SECTION]); $i++) {
            if ($entry[self::CALLS_SECTION][$i][0] == self::SET_ACTIVE_SHOPS_METHOD) {
                $entry[self::CALLS_SECTION][$i][1][0] = array_values(
                    array_diff($entry[self::CALLS_SECTION][$i][1][0], $shopIds));
            }
        }
        return $entry;
    }

    /**
     * Receives a service definition as array and then
     * finds the method call to set the shopIds. It then
     * updates the shopIds parameter and returns the
     * updated definition.
     *
     * @param array $entry
     * @param array $shopIds
     *
     * @return array
     */
    private function addShopIdsToEntry(array $entry, array $shopIds)
    {
        $entry = $this->addDefaultCallsIfMissing($entry);
        for ($i = 0; $i < sizeof($entry[self::CALLS_SECTION]); $i++) {
            if ($entry[self::CALLS_SECTION][$i][0] == self::SET_ACTIVE_SHOPS_METHOD) {
                $entry[self::CALLS_SECTION][$i] = $this->addShopIdsToCall($entry[self::CALLS_SECTION][$i], $shopIds);
            }
        };

        return $entry;
    }

    /**
     * Adds the shopIds to the parameter array (the second element
     * of the call are the parameters, the first parameter then
     * contains the shopIds).
     *
     * Returns the updated call.
     *
     * @param array $call
     * @param array $shopIds
     *
     * @return array
     */
    private function addShopIdsToCall(array $call, array $shopIds)
    {

        $currentShopIds = $call[1][0];
        foreach ($shopIds as $shopId) {
            if (!in_array($shopId, $currentShopIds)) {
                $currentShopIds[] = $shopId;
            }
        }
        $call[1][0] = $currentShopIds;

        return $call;
    }

    /**
     * Extracts the event subscriber definitions from a yaml file
     * defining the services of a module.
     *
     * @param string $modulePath
     *
     * @return array
     */
    private function getSubscriberEntries($modulePath)
    {

        $subscriberKeys = $this->findModuleEventSubscribers($modulePath);

        $yaml = Yaml::parse(file_get_contents($modulePath . DIRECTORY_SEPARATOR . self::SERVICES_FILE_NAME));
        $services = $yaml[self::SERVICES_SECTION];
        $entries = [];
        foreach ($services as $name => $fields) {
            if (in_array(strtolower($name), $subscriberKeys)) {
                $entries[$name] = $fields;
            }
        }

        return $entries;
    }

    /**
     * Loads the current valid definition for a certain event
     * subscriber.
     *
     * @param $subscriberKey
     *
     * @return \Symfony\Component\DependencyInjection\Definition
     */
    private function getSymfonyEventSubscriberDefinition($subscriberKey)
    {
        $symfonyContainer = new ContainerBuilder();
        $loader = new YamlFileLoader($symfonyContainer, new FileLocator($this->context->getShopDir()));
        $loader->load(self::PROJECT_FILE_NAME);

        return $symfonyContainer->getDefinition($subscriberKey);
    }

    private function addImportSectionIfMissing(array $projectDefinitionArray)
    {
        if (! array_key_exists(self::IMPORTS_SECTION, $projectDefinitionArray)) {
            $projectDefinitionArray[self::IMPORTS_SECTION] = [];
        }
        return $projectDefinitionArray;
    }

    /**
     * Just makes sure that the service definition has the two
     * method calls for setting the shopIds and setting the
     * Context object.
     *
     * Returns the updated service definition.
     *
     * @param $entry
     *
     * @return array
     */
    private function addDefaultCallsIfMissing($entry)
    {
        if (!array_key_exists(self::CALLS_SECTION, $entry)) {
            $entry[self::CALLS_SECTION] = [];
        }

        $entry = $this->addCallIfMissing($entry, [self::SET_ACTIVE_SHOPS_METHOD, self::SET_ACTIVE_PARAMETERS]);
        $entry = $this->addCallIfMissing($entry, [self::SET_CONTEXT_METHOD, self::SET_CONTEXT_PARAMETERS]);

        return $entry;
    }

    /**
     * Helper function to add a new call to the calls
     * section of a service definition.
     *
     * @param array $entry
     * @param array $call
     *
     * @return array
     */
    private function addCallIfMissing(array $entry, array $call)
    {

        foreach ($entry[self::CALLS_SECTION] as $existingCall) {
            if ($existingCall[0] == $call[0]) {
                return $entry;
            }
        }
        $entry[self::CALLS_SECTION][] = $call;

        return $entry;
    }

    /**
     * Write the project definition
     *
     * @param $projectYaml
     */
    private function writeProjectFile(array $projectYaml)
    {
        file_put_contents($this->getProjectFileName(), Yaml::dump($projectYaml, 3, 2));
    }

    /**
     * Read the project definition
     *
     * @return mixed
     */
    private function readProjectFile()
    {
        $yamlArray = Yaml::parse(file_get_contents($this->getProjectFileName()));
        if (is_null($yamlArray)) {
            $yamlArray = [];
        }
        return $yamlArray;
    }

    /**
     * @return string
     */
    private function getProjectFileName()
    {
        return $this->context->getShopDir() . DIRECTORY_SEPARATOR . self::PROJECT_FILE_NAME;
    }

}