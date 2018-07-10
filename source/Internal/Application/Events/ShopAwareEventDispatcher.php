<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 27.06.18
 * Time: 14:56
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;


use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class ShopAwareEventDispatcher extends ContainerAwareEventDispatcher
{
    protected function doDispatch($listeners, $eventName, Event $event)
    {
        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }
            if (is_array($listener) &&
                is_object($listener[0]) &&
                in_array(ShopAwareEventSubscriberInterface::class, class_implements($listener[0])) &&
                ! $listener[0]->isActive()) {
                    continue;
            }
            call_user_func($listener, $event, $eventName, $this);
        }
    }

}