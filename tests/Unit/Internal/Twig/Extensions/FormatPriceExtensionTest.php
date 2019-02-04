<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatPriceLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\FormatPriceExtension;

class FormatPriceExtensionTest extends AbstractExtensionTest
{

    protected function setUp(): void
    {
        parent::setUp();
        $formatPriceLogic = new FormatPriceLogic();
        $this->extension = new FormatPriceExtension($formatPriceLogic);
    }

    /**
     * @return array
     */
    public function priceProvider(): array
    {
        return [
            ['{{ format_price(100) }}', '100,00 €'],
            ['{{ format_price(100, {"currency" : {"sign" : "$"}}) }}', '100,00 $'],
        ];
    }

    /**
     *
     * @dataProvider priceProvider
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\FormatPriceExtension::formatPrice
     */
    public function testFormatPrice($template, $expected): void
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }
}
