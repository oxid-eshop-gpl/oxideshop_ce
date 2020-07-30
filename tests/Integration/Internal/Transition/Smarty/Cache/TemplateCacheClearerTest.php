<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Transition\Smarty\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\CacheClearerInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererInterface;
use OxidEsales\EshopCommunity\Tests\Integration\Internal\ContainerTrait;
use PHPUnit\Framework\TestCase;

class TemplateCacheClearerTest extends TestCase
{
    use ContainerTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->cleanUpSmartyCompileDirectory();
    }

    public function tearDown(): void
    {
        $this->cleanUpSmartyCompileDirectory();
        rmdir($this->getSmartyCompileDirectory());
        parent::tearDown();
    }

    public function testClearDefinedTemplates()
    {
        $templateToLeave = 'templateToLeave.tpl';
        $templatesToRemove = ['templateToRemove.tpl', 'templateToRemove2.tpl'];
        $templatesToRender = array_merge($templatesToRemove, [$templateToLeave]);

        $this->renderTemplates($templatesToRender);
        $this->assertTemplatesAreCached($templatesToRender);

        $cacheClearer = $this->get(CacheClearerInterface::class);
        $cacheClearer->clear($templatesToRemove);

        $this->assertTemplatesAreCached([$templateToLeave]);
        $this->assertTemplatesRemovedFromCache($templatesToRemove);
    }

    private function renderTemplates(array $templatesToRender): void
    {
        $renderer = $this->getRenderer();
        foreach ($templatesToRender as $template) {
            $renderer->renderTemplate($template);
        }
    }

    private function assertTemplatesAreCached(array $templates): void
    {
        foreach ($templates as $template) {
            $renderedFile = $this->getCompiledFileName($template);
            $this->assertEquals(1, count(glob($renderedFile)), 'File not found: ' . $renderedFile);
        }
    }

    private function assertTemplatesRemovedFromCache(array $templates): void
    {
        foreach ($templates as $template) {
            $renderedFile = $this->getCompiledFileName($template);
            $this->assertEquals(0, count(glob($renderedFile)), 'File should be deleted: ' . $renderedFile);
        }
    }

    private function getRenderer(): TemplateRendererInterface
    {
        $rendererBridge = $this->get(TemplateRendererBridgeInterface::class);
        $rendererBridge->setEngine($this->getEngine());
        return $rendererBridge->getTemplateRenderer();
    }

    private function getEngine(): \Smarty
    {
        $smarty = new \Smarty();
        $smarty->compile_dir = $this->getSmartyCompileDirectory();
        $smarty->left_delimiter = '[{';
        $smarty->right_delimiter = '}]';
        $smarty->template_dir = [$this->getTemplateDirectory()];
        return $smarty;
    }

    private function getSmartyCompileDirectory(): string
    {
        $smartyTmpDir = sys_get_temp_dir() . '/smarty';
        if (!file_exists($smartyTmpDir)) {
            mkdir($smartyTmpDir);
        }
        return $smartyTmpDir;
    }

    private function getTemplateDirectory(): string
    {
        return __DIR__ . '/Fixtures/';
    }

    private function getCompiledFileName(string $template): string
    {
        return $this->getSmartyCompileDirectory() . '/*' . basename($template) . '.php';
    }

    private function cleanUpSmartyCompileDirectory(): void
    {
        array_map('unlink', glob($this->getSmartyCompileDirectory() . '/*'));
    }
}
