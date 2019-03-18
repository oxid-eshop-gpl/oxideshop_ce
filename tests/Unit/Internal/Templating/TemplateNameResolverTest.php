<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Templating;

use OxidEsales\EshopCommunity\Internal\Templating\TemplateNameResolver;

class TemplateNameResolverTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider resolveSmartyDataProvider
     */
    public function testResolveSmartyTemplate($templateName, $response)
    {
        $resolver = new TemplateNameResolver();

        $this->assertSame($response, $resolver->resolve($templateName, 'tpl'));
    }

    public function resolveSmartyDataProvider()
    {
        return [
            [
                'template',
                'template.tpl'
            ],
            [
                'some/path/template',
                'some/path/template.tpl'
            ],
            [
                'some/path/template_name',
                'some/path/template_name.tpl'
            ],
            [
                'some/path/template.name',
                'some/path/template.name.tpl'
            ],
            [
                '',
                ''
            ]
        ];
    }

    /**
     * @dataProvider resolveTwigDataProvider
     */
    public function testResolveTwigTemplate($response, $templateName)
    {
        $resolver = new TemplateNameResolver();

        $this->assertSame($response, $resolver->resolve($templateName, 'html.twig'));
    }

    public function resolveTwigDataProvider()
    {
        return [
            [
                'template.html.twig',
                'template'
            ],
            [
                'some/path/template_name.html.twig',
                'some/path/template_name'
            ],
            [
                'some/path/template.name.html.twig',
                'some/path/template.name'
            ],
            [
                '',
                ''
            ]
        ];
    }

}
