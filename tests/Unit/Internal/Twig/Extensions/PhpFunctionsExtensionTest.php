<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\PhpFunctionsExtension;
use PHPUnit\Framework\TestCase;

class PhpFunctionsExtensionTest extends AbstractExtensionTest
{

    /** @var PhpFunctionsExtension */
    protected $extension;

    public function setUp()
    {
        $this->extension = new PhpFunctionsExtension();
    }

    /**
     * @return array
     */
    public function dummyTemplateProvider(): array
    {
        return [
            ["{{ count({0:0, 1:1, 2:2}) }}", 3],
            ["{{ empty({0:0, 1:1}) }}", false],
            ["{{ empty({}) }}", true],
            ["{{ foo is isset }}", false],
            ["{% set foo = 'bar' %} {{ foo is isset }}", true],
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
}
