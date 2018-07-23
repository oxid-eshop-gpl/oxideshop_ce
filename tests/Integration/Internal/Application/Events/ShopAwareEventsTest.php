<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:41
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


use OxidEsales\Eshop\Core\Config;
use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Application\PSR11Compliance\ContainerWrapper;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\ContextStub;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShopAwareEventsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /** @var Config originalConfig */
    private $originalConfig;

    public function setUp()
    {
        $this->originalConfig = Registry::get(\OxidEsales\Eshop\Core\Config::class);
        Registry::set(\OxidEsales\Eshop\Core\Config::class, new TestConfig());

        $factory = ContainerFactory::getInstance();
        $factory->resetContainer();

        $this->container = $factory->getContainer();
        $this->dispatcher = $this->container->get('event_dispatcher');
    }

    public function tearDown()
    {
        Registry::set(\OxidEsales\Eshop\Core\Config::class, $this->originalConfig);
        ContainerFactory::getInstance()->resetContainer();
    }

    /**
     * All three subscribers are active for shop 1, current shop is 1
     * but propagation is stopped after the second handler, so
     * we should have 2 active event handlers
     */
    public function testShopActivatedEvent() {

        /**
         * @var $event TestEvent
         */
        $event = $this->dispatcher->dispatch('oxidesales.testevent', new TestEvent());
        $this->assertEquals(2, $event->getNumberOfActiveHandlers());

    }

    /**
     * Only the second and third subscriber are active for shop 2, current shop is 2
     * but propagation is stopped after the second handler, so
     * we should have 1 active event handler
     */
    public function testShopNotActivatedEvent() {

        /**
         * @var ContextStub $contextStub
         */
        $contextStub = $this->container->get('OxidEsales\EshopCommunity\Internal\Utility\ContextInterface');
        $contextStub->setCurrentShopId(2);
        /**
         * @var $event TestEvent
         */
        $event = $this->dispatcher->dispatch('oxidesales.testevent', new TestEvent());
        $this->assertEquals(1, $event->getNumberOfActiveHandlers());

    }
}
