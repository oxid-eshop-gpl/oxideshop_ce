<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataMapper\ModuleConfiguration;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataMapper\ModuleConfigurationDataMapperInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration\Template;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration\ThemedTemplate;

class TemplatesDataMapper implements ModuleConfigurationDataMapperInterface
{
    public const MAPPING_KEY = 'templates';

    public function toData(ModuleConfiguration $configuration): array
    {
        $data = [];

        if ($configuration->hasTemplates()) {
            $data[self::MAPPING_KEY] = $this->getTemplates($configuration);
        }

        return $data;
    }

    public function fromData(ModuleConfiguration $moduleConfiguration, array $data): ModuleConfiguration
    {
        if (isset($data[self::MAPPING_KEY])) {
            $this->setTemplates($moduleConfiguration, $data[self::MAPPING_KEY]);
        }

        return $moduleConfiguration;
    }

    /**
     * @param ModuleConfiguration $moduleConfiguration
     * @param array $template
     */
    private function setTemplates(ModuleConfiguration $moduleConfiguration, array $template): void
    {
        foreach ($template as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $themedTemplateKey => $themedTemplatePath) {
                    $moduleConfiguration->addTemplate(
                        new ThemedTemplate($themedTemplateKey, $themedTemplatePath, $key)
                    );
                }
            } else {
                $moduleConfiguration->addTemplate(
                    new Template($key, $value)
                );
            }
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
            if ($template instanceof ThemedTemplate) {
                $templates[$template->getTemplateTheme()][$template->getTemplateKey()] = $template->getTemplatePath();
            } else {
                $templates[$template->getTemplateKey()] = $template->getTemplatePath();
            }
        }
        return $templates;
    }
}
