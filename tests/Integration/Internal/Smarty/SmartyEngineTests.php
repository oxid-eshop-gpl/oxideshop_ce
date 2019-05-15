<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Smarty;

use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Smarty\SmartyEngine;

class SmartyEngineTest extends \PHPUnit\Framework\TestCase
{

    public function testExists()
    {
        $template = $this->getTemplateDirectory() . 'smartyTemplate.tpl';

        $engine = $this->getEngine();

        $this->assertTrue($engine->exists($template));
    }

    public function testExistsWithNonExistentTemplates()
    {
        $engine = $this->getEngine();

        $this->assertFalse($engine->exists('foobar'));
    }

    public function testRender()
    {
        $template = $this->getTemplateDirectory() . 'smartyTemplate.tpl';

        $engine = $this->getEngine();

        $this->assertTrue(file_exists($template));
        $this->assertSame('Hello OXID!', $engine->render($template));
    }

    public function testRenderFragment()
    {
        $fragment = '[{assign var=\'title\' value=$title|default:\'Hello OXID!\'}][{$title}]';

        $factory = ContainerFactory::getInstance()->getContainer();
        $engine = $factory->get(SmartyEngine::class);
        $engine->setCacheId('ox:testid');

        $this->assertSame('Hello OXID!', $engine->renderFragment($fragment));
    }

    private function getEngine()
    {
        $smarty = new \Smarty();
        $smarty->compile_dir = sys_get_temp_dir();
        $smarty->left_delimiter = '[{';
        $smarty->right_delimiter = '}]';
        return new SmartyEngine($smarty);
    }

    private function getTemplateDirectory()
    {
        return __DIR__ . '/Fixtures/';
    }
}