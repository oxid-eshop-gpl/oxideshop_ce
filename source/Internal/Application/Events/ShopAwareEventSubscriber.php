<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 27.06.18
 * Time: 14:59
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;

use OxidEsales\EshopCommunity\Internal\Utility\ContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class ShopAwareEventSubscriber implements EventSubscriberInterface, ShopAwareEventSubscriberInterface
{

    /**
     * @var ContextInterface
     */
    private $context;
    /**
     * @var array
     */
    private $activeShops;

    public function setActiveShops(array $activeShops) {
        $this->activeShops = $activeShops;
    }
    public function setContext(ContextInterface $context) {
        $this->context = $context;
    }
    public function isActive() {
        return in_array(strval($this->context->getCurrentShopId()), $this->activeShops);
    }
}