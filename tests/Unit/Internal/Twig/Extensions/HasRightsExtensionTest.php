<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension;
use OxidEsales\EshopCommunity\Internal\Twig\Node\HasRightsNode;
use OxidEsales\EshopCommunity\Internal\Twig\TokenParser\HasRightsTokenParser;
use PHPUnit\Framework\TestCase;

class HasRightsExtensionTest extends TestCase
{

    /**
     * @var HasRightsExtension
     */
    private $hasRightsExtension;

    protected function setUp()
    {
        $this->hasRightsExtension = new HasRightsExtension(new HasRightsTokenParser(HasRightsNode::class));
        parent::setUp();
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension::getTokenParsers
     */
    public function testGetTokenParsers()
    {
        $tokenParser = $this->hasRightsExtension->getTokenParsers();
        $this->assertInstanceOf(HasRightsTokenParser::class, $tokenParser[0]);
    }
}
