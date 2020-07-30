<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\EventSubscriber;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ModuleConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\CacheClearerInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\ShopAdapterInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\BeforeModuleDeactivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleActivationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DispatchLegacyEventsSubscriber implements EventSubscriberInterface
{
    /**
     * @var ModuleConfigurationDaoInterface
     */
    private $moduleConfigurationDao;
    /**
     * @var ShopAdapterInterface
     */
    private $shopAdapter;

    /**
     * @var CacheClearerInterface
     */
    private $cacheClearer;

    /**
     * @param ModuleConfigurationDaoInterface $ModuleConfigurationDao
     * @param CacheClearerInterface                 $cacheClearer
     * @param ShopAdapterInterface            $shopAdapter
     */
    public function __construct(
        ModuleConfigurationDaoInterface $ModuleConfigurationDao,
        CacheClearerInterface $cacheClearer,
        ShopAdapterInterface $shopAdapter
    ) {
        $this->moduleConfigurationDao = $ModuleConfigurationDao;
        $this->cacheClearer = $cacheClearer;
        $this->shopAdapter = $shopAdapter;
    }

    /**
     * @param FinalizingModuleActivationEvent $event
     */
    public function executeMetadataOnActivationEvent(FinalizingModuleActivationEvent $event)
    {
        $this->invalidateModuleCache($event);
        $this->executeMetadataEvent(
            'onActivate',
            $event->getModuleId(),
            $event->getShopId()
        );
    }

    /**
     * @param BeforeModuleDeactivationEvent $event
     */
    public function executeMetadataOnDeactivationEvent(BeforeModuleDeactivationEvent $event)
    {
        $this->executeMetadataEvent(
            'onDeactivate',
            $event->getModuleId(),
            $event->getShopId()
        );
    }

    /**
     * @param string $eventName
     * @param string $moduleId
     * @param int    $shopId
     */
    private function executeMetadataEvent(string $eventName, string $moduleId, int $shopId)
    {
        $moduleConfiguration = $this->moduleConfigurationDao->get($moduleId, $shopId);

        if ($moduleConfiguration->hasEvents()) {
            $events = [];

            foreach ($moduleConfiguration->getEvents() as $event) {
                $events[$event->getAction()] = $event->getMethod();
            }

            if (\is_array($events) && array_key_exists($eventName, $events)) {
                \call_user_func($events[$eventName]);
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FinalizingModuleActivationEvent::NAME   => 'executeMetadataOnActivationEvent',
            BeforeModuleDeactivationEvent::NAME     => 'executeMetadataOnDeactivationEvent',
        ];
    }

    /**
     * This is needed only for the modules which has non namespaced classes.
     * This method MUST be removed when support for non namespaced modules will be dropped (metadata v1.*).
     *
     * @param FinalizingModuleActivationEvent $event
     */
    private function invalidateModuleCache(FinalizingModuleActivationEvent $event)
    {
        $this->shopAdapter->invalidateModuleCache($event->getModuleId());
        $this->invalidateTemplateCache($event->getModuleId(), $event->getShopId());
    }

    /**
     * @param string $moduleId
     * @param int    $shopId
     */
    private function invalidateTemplateCache(string $moduleId, int $shopId): void
    {
        $moduleConfiguration = $this->moduleConfigurationDao->get($moduleId, $shopId);
        if ($moduleConfiguration->hasTemplates()) {
            $this->cacheClearer->clear($this->getTemplates($moduleConfiguration));
        }
    }

    /**
     * @param ModuleConfiguration $configuration
     *
     * @return array
     */
    private function getTemplates(ModuleConfiguration $configuration): array
    {
        $templates = [];

        foreach ($configuration->getTemplates() as $template) {
            $templates[$template->getTemplateKey()] = $template->getTemplateKey();
        }

        return $templates;
    }
}
