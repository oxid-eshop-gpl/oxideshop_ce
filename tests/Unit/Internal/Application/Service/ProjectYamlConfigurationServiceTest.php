<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 03.07.18
 * Time: 11:51
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Application\Service;


use OxidEsales\EshopCommunity\Internal\Application\Service\ProjectYamlConfigurationService;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\ContextStub;
use Symfony\Component\Yaml\Yaml;

class ProjectYamlConfigurationServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContextStub
     */
    private $context;

    /**
     * @var ProjectYamlConfigurationService
     */
    private $service;

    private $moduleDir = __DIR__ . '/Testmodule';

    private $sourceDir = __DIR__ . '/SourceDir';

    public function setUp()
    {
        $this->context = new ContextStub();
        $this->service = new ProjectYamlConfigurationService($this->context);
        $this->context->setShopDir($this->sourceDir);

    }

    public function testGetActiveShopsForEventSubscriberDefault()
    {
        file_put_contents($this->sourceDir . '/project.yaml', '');
        $this->service->addImport($this->moduleDir);

        $this->context->setShopDir($this->sourceDir);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('somemodule\events\testeventsubscriber');

        $this->assertEquals(0, sizeof($activeShops));
    }

    public function testGetActiveShopsForEventSubscriberWithShop()
    {
        $data = <<<EOT
services:
  SomeModule\Events\TestEventSubscriber:
    class: SomeModule\Events\TestEventSubscriber
    arguments: { \$someService: '@SomeModule\Service\SomeOtherService' }
    tags: [{ name: kernel.event_subscriber }]
    calls:
      - [setActiveShops, [[1]]]
      - [setContext, ['@OxidEsales\EshopCommunity\Internal\Utility\ContextInterface']]

EOT;

        file_put_contents($this->sourceDir . '/project.yaml', $data);
        $this->service->addImport($this->moduleDir);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('somemodule\events\testeventsubscriber');

        $this->assertEquals(1, sizeof($activeShops));
        $this->assertEquals(1, $activeShops[0]);
    }


    public function testFindingSubscriberKeys()
    {
        $keys = $this->service->findModuleEventSubscribers($this->moduleDir);

        $this->assertEquals(1, sizeof($keys));
        $this->assertEquals('SomeModule\Events\TestEventSubscriber', $keys[0]);
    }

    public function testAddFirstActiveShopToEventSubscribers() {

        file_put_contents($this->sourceDir . '/project.yaml', '');
        $this->service->addImport($this->moduleDir);

        $this->service->addActiveShopsToEventSubscribers($this->moduleDir, [2]);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('SomeModule\Events\TestEventSubscriber');

        $this->assertEquals(1, sizeof($activeShops));
        $this->assertEquals(2, $activeShops[0]);

    }

    public function testAddAdditionalActiveShopToEventSubscribers() {

        $data = <<<EOT
services:
  SomeModule\Events\TestEventSubscriber:
    class: SomeModule\Events\TestEventSubscriber
    arguments: { \$someService: '@SomeModule\Service\SomeOtherService' }
    tags: [{ name: kernel.event_subscriber }]
    calls:
      - [setActiveShops, [[1]]]
      - [setContext, ['@OxidEsales\EshopCommunity\Internal\Utility\ContextInterface']]

EOT;

        file_put_contents($this->sourceDir . '/project.yaml', $data);
        $this->service->addImport($this->moduleDir);

        $this->service->addActiveShopsToEventSubscribers($this->moduleDir, [2]);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('somemodule\events\testeventsubscriber');

        $this->assertEquals(2, sizeof($activeShops));
        $this->assertEquals(1, $activeShops[0]);
        $this->assertEquals(2, $activeShops[1]);

    }

    public function testAddImport() {

        file_put_contents($this->sourceDir . '/project.yaml', '');

        $this->service->addImport($this->moduleDir);

        $yaml = Yaml::parse(file_get_contents($this->sourceDir . '/project.yaml'));
        $this->assertEquals(1, sizeof($yaml['imports']));
        $this->assertEquals('Testmodule/services.yaml', substr($yaml['imports'][0]['resource'], -24));
    }

    public function testAddImportNotExisting() {

        $this->setExpectedException(\Exception::class);

        file_put_contents($this->sourceDir . '/project.yaml', '');

        $this->context->setShopDir($this->sourceDir);

        $this->service->addImport($this->sourceDir);

    }

    public function testMultipleImportAdding() {

        file_put_contents($this->sourceDir . '/project.yaml', '');


        $this->service->addImport($this->moduleDir);
        # Should be the same
        $this->service->addImport($this->moduleDir . '/');

        $yaml = Yaml::parse(file_get_contents($this->sourceDir . '/project.yaml'));
        $this->assertEquals(1, sizeof($yaml['imports']));
        $this->assertEquals('Testmodule/services.yaml', substr($yaml['imports'][0]['resource'], -24));
    }

    public function testRemoveImport() {

        file_put_contents($this->sourceDir . '/project.yaml', '');


        $this->service->addImport($this->moduleDir);
        $this->service->removeImport($this->moduleDir);

        $yaml = Yaml::parse(file_get_contents($this->sourceDir . '/project.yaml'));
        $this->assertEquals(0, sizeof($yaml['imports']));

    }

    public function testRemoveNonexistingImport() {

        $data = <<<EOT
imports:
  -
    resource: /some/non/existing/path/services.yaml

EOT;
        file_put_contents($this->sourceDir . '/project.yaml', $data);

        $this->service->removeImport('/some/non/existing/path');

        $yaml = Yaml::parse(file_get_contents($this->sourceDir . '/project.yaml'));
        $this->assertEquals(0, sizeof($yaml['imports']));

    }

    public function testRemoveNonexistingImportSection() {

        file_put_contents($this->sourceDir . '/project.yaml', '');

        $this->service->removeImport('/some/non/existing/path');

        $yaml = Yaml::parse(file_get_contents($this->sourceDir . '/project.yaml'));
        $this->assertEquals(0, sizeof($yaml['imports']));

    }

    public function testRemoveEmptyImportsSection() {

        $data = <<<EOT
imports:

EOT;
        file_put_contents($this->sourceDir . '/project.yaml', $data);

        $this->service->removeImport('/some/non/existing/path');

        $yaml = Yaml::parse(file_get_contents($this->sourceDir . '/project.yaml'));
        $this->assertEquals(0, sizeof($yaml['imports']));

    }

    public function testRemoveActiveShopsFromEventSubscribers() {

        $data = <<<EOT
services:
  SomeModule\Events\TestEventSubscriber:
    class: SomeModule\Events\TestEventSubscriber
    arguments: { \$someService: '@SomeModule\Service\SomeOtherService' }
    tags: [{ name: kernel.event_subscriber }]
    calls:
      - [setActiveShops, [[1, 2, 3, 4]]]
      - [setContext, ['@OxidEsales\EshopCommunity\Internal\Utility\ContextInterface']]

EOT;

        file_put_contents($this->sourceDir . '/project.yaml', $data);
        $this->service->addImport($this->moduleDir);

        $this->service->removeActiveShopsFromEventSubscribers($this->moduleDir, [2, 4]);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('somemodule\events\testeventsubscriber');

        $this->assertEquals(2, sizeof($activeShops));
        $this->assertEquals(1, $activeShops[0]);
        $this->assertEquals(3, $activeShops[1]);

    }

    public function testRemoveActiveShopsFromEventSubscribersNoServicesSection() {

        file_put_contents($this->sourceDir . '/project.yaml', '');
        $this->service->addImport($this->moduleDir);

        $this->service->removeActiveShopsFromEventSubscribers($this->moduleDir, [2, 4]);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('somemodule\events\testeventsubscriber');

        $this->assertEquals(0, sizeof($activeShops));

    }

    public function testRemoveActiveShopsFromEventSubscribersNoCallsSection() {

        $data = <<<EOT
services:
  SomeModule\Events\TestEventSubscriber:
    class: SomeModule\Events\TestEventSubscriber
    arguments: { \$someService: '@SomeModule\Service\SomeOtherService' }
    tags: [{ name: kernel.event_subscriber }]

EOT;

        file_put_contents($this->sourceDir . '/project.yaml', $data);
        $this->service->addImport($this->moduleDir);

        $this->service->removeActiveShopsFromEventSubscribers($this->moduleDir, [2, 4]);

        $activeShops = $this->service->getActiveShopsForEventSubscriber('somemodule\events\testeventsubscriber');

        $this->assertEquals(0, sizeof($activeShops));

    }
}
