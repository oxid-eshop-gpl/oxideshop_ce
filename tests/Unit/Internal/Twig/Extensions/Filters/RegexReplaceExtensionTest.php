<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\RegexReplaceExtension;
use OxidEsales\TestingLibrary\UnitTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class RegexReplaceExtensionTest extends UnitTestCase
{
    /** @var RegexReplaceExtension */
    protected $extension;

    public function setUp()
    {
        $this->extension = new RegexReplaceExtension();
    }

    /**
     * @return array
     */
    public function dummyTemplateProvider(): array
    {
        return [
            ["{{ '1-foo-2'|regex_replace('/[0-9]/', 'bar') }}", "bar-foo-bar"],
        ];
    }

    /**
     * @param string $template
     * @param string $expected
     *
     * @dataProvider dummyTemplateProvider
     */
    public function testIfPhpFunctionsAreCallable(string $template, string $expected)
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @param string $template
     *
     * @return \Twig_Template
     */
    private function getTemplate(string $template): \Twig_Template
    {
        $loader = new ArrayLoader(['index' => $template]);

        $twig = new Environment($loader, ['debug' => true, 'cache' => false]);
        $twig->addExtension($this->extension);

        return $twig->loadTemplate('index');
    }
}
