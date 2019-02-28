<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\CaptureExtension;
use OxidEsales\EshopCommunity\Internal\Twig\TokenParser\CaptureTokenParser;
use PHPUnit\Framework\TestCase;

class CaptureExtensionTest extends TestCase
{

    /**
     * @var CaptureExtension
     */
    private $CaptureExtension;

    protected function setUp()
    {
        $this->CaptureExtension = new CaptureExtension();
        parent::setUp();
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\CaptureExtension::getTokenParsers
     */
    public function testGetTokenParsers()
    {
        $tokenParser = $this->CaptureExtension->getTokenParsers();
        $this->assertInstanceOf(CaptureTokenParser::class, $tokenParser[0]);
    }
}
