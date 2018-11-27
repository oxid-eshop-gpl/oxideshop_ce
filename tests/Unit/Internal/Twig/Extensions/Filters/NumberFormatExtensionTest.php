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

    public function testNumberFormat()
    {
        $template = "{{ 'EUR@ 1.00@ .@ ,@ EUR@ 2'|number_format(25000000.5584) }}";
        $expected = '25,000,000.56';

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }
}
