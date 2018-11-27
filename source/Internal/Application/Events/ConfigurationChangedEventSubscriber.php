<?php declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Application\Events;

use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Utility\ContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @internal
 */
class ConfigurationChangedEventSubscriber implements EventSubscriberInterface
{

    /**
     * @var ContextInterface $context
     */
    private $context;

    /**
     * ConfigurationChangedEventSubscriber constructor.
     *
     * @param ContextInterface $context
     */
    public function __construct(ContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * @param ProjectYamlChangedEvent $event
     */
    public function resetContainer(ProjectYamlChangedEvent $event)
    {
        ContainerFactory::resetContainer();
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     * * The method name to call (priority defaults to 0)
     * * An array composed of the method name to call and the priority
     * * An array of arrays composed of the method names to call and respective
     *   priorities, or 0 if unset
     *
     * For instance:
     *
     * * array('eventName' => 'methodName')
     * * array('eventName' => array('methodName', $priority))
     * * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [ProjectYamlChangedEvent::NAME => 'resetContainer'];
    }
}
