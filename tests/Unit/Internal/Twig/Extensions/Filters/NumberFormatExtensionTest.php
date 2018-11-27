<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\NumberFormatLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\NumberFormatExtension;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\AbstractExtensionTest;

/**
 * Class NumberFormatExtensionTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class NumberFormatExtensionTest extends AbstractExtensionTest
{

    /** @var NumberFormatExtension */
    protected $extension;

    public function setUp()
    {
        $this->extension = new NumberFormatExtension(new NumberFormatLogic());
    }

    /**
     * Provides data to testNumberFormat
     *
     * @return array
     */
    public function numberFormatProvider(): array
    {
        return [
            ["{{ 'EUR@ 1.00@ ,@ .@ EUR@ 2'|number_format(25000) }}", '25.000,00'],
            ["{{ 'EUR@ 1.00@ ,@ .@ EUR@ 2'|number_format(25000.1584) }}", '25.000,16'],
            ["{{ 'EUR@ 1.00@ ,@ .@ EUR@ 3'|number_format(25000.1584) }}", '25.000,158'],
            ["{{ 'EUR@ 1.00@ ,@ .@ EUR@ 0'|number_format(25000000.5584) }}", '25.000.001'],
            ["{{ 'EUR@ 1.00@ .@ ,@ EUR@ 2'|number_format(25000000.5584) }}", '25,000,000.56'],
        ];
    }

    /**
     * @param string $template
     * @param string $expected
     *
     * @dataProvider numberFormatProvider
     */
    public function testNumberFormat($template, $expected)
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }
}
