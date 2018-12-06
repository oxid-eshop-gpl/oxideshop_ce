<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\HasRightsExtension;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsExtension;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsParser;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsVisitor;
use PHPUnit\Framework\TestCase;

class HasRightsExtensionTest extends TestCase
{

    /**
     * @var HasRightsExtension
     */
    private $hasRightsExtension;

    protected function setUp(): void
    {
        $this->hasRightsExtension = new HasRightsExtension();
        parent::setUp();
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsExtension::getTokenParsers
     */
    public function testGetTokenParsers(): void
    {
        $tokenParser = $this->hasRightsExtension->getTokenParsers();
        $this->assertInstanceOf(HasRightsParser::class, $tokenParser[0]);
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsExtension::getNodeVisitors
     */
    public function testGetNodeVisitors(): void
    {
        $nodeVisitors = $this->hasRightsExtension->getNodeVisitors();
        $this->assertInstanceOf(HasRightsVisitor::class, $nodeVisitors[0]);
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsExtension::getGetName
     */
    public function testGetName(): void
    {
        $this->assertEquals('hasrights', $this->hasRightsExtension->getName());
    }
}
