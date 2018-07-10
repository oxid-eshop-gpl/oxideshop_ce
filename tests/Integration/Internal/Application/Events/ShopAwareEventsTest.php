<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:41
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


use OxidEsales\EshopCommunity\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Application\PSR11Compliance\ContainerWrapper;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\ContextStub;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShopAwareEventsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContainerWrapper
     */
    private $container;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;


    public function setUp()
    {
        $this->removeCache();
        Registry::set(\OxidEsales\Eshop\Core\Config::class, new TestConfig());

        $this->container = ContainerFactory::getInstance()->getContainer();
        $this->dispatcher = $this->container->get('event_dispatcher');
    }

    public function tearDown()
    {
        $this->removeCache();
    }

    private function removeCache()
    {
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'containercache.php'))
        {
            unlink(__DIR__ . DIRECTORY_SEPARATOR . 'containercache.php');
        }
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
