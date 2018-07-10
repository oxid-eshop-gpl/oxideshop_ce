<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 28.06.18
 * Time: 10:07
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;

use OxidEsales\EshopCommunity\Internal\Utility\ContextInterface;

interface ShopAwareEventSubscriberInterface
{

    public function setActiveShops(array $activeShops);

    public function setContext(ContextInterface $context);

    public function isActive();
}