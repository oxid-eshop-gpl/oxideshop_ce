<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatPriceLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\FormatPriceExtension;
use PHPUnit\Framework\TestCase;

class FormatPriceExtensionTest extends TestCase
{

    /**
     * @var FormatPriceExtension
     */
    private $formatPriceExtension;

    protected function setUp(): void
    {
        parent::setUp();
        $formatPriceLogic = new FormatPriceLogic();
        $this->formatPriceExtension = new FormatPriceExtension($formatPriceLogic);
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\FormatPriceExtension::formatPrice
     */
    public function testFormatPrice(): void
    {
        $price = $this->formatPriceExtension->formatPrice(['price' => 100]);
        $this->assertEquals('100,00 €', $price);
    }
}
