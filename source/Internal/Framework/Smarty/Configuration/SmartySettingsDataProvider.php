<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Configuration;

use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Extension\SmartyTemplateHandlerInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Smarty\SmartyContextInterface;

class SmartySettingsDataProvider implements SmartySettingsDataProviderInterface
{
    /**
     * @var SmartyContextInterface
     */
    private $context;

    /**
     * @var SmartyTemplateHandlerInterface
     */
    private $smartyTemplateHandler;

    /**
     * SmartySettingsDataProvider constructor.
     *
     * @param SmartyContextInterface         $context
     * @param SmartyTemplateHandlerInterface $smartyTemplateHandler
     */
    public function __construct(SmartyContextInterface $context, SmartyTemplateHandlerInterface $smartyTemplateHandler)
    {
        $this->context = $context;
        $this->smartyTemplateHandler = $smartyTemplateHandler;
    }

    /**
     * Define and return basic smarty settings
     *
     * @return array
     */
    public function getSettings(): array
    {
        $compilePath = $this->getTemplateCompilePath();
        return [
            'caching' => false,
            'left_delimiter' => '[{',
            'right_delimiter' => '}]',
            'compile_dir' => $compilePath,
            'cache_dir' => $compilePath,
            'template_dir' => $this->context->getTemplateDirectories(),
            'compile_id' => $this->getTemplateCompileId(),
            'default_template_handler_func' => [$this->smartyTemplateHandler, 'handleTemplate'],
            'debugging' => $this->context->getTemplateEngineDebugMode(),
            'compile_check' => $this->context->getTemplateCompileCheckMode(),
            'php_handling' => (int) $this->context->getTemplatePhpHandlingMode(),
            'security' => false
        ];
    }

    /**
     * Returns a full path to Smarty compile dir
     *
     * @return string
     */
    private function getTemplateCompilePath(): string
    {
        return $this->context->getTemplateCompileDirectory();
    }

    /**
     * Get template compile id.
     *
     * @return string
     */
    private function getTemplateCompileId(): string
    {
        return $this->context->getTemplateCompileId();
    }
}
