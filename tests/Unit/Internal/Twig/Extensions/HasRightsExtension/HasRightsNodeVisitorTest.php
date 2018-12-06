<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\HasRightsExtension;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsVisitor;
use PHPUnit\Framework\TestCase;
use Twig\Loader\ArrayLoader;

class HasRightsNodeVisitorTest extends TestCase
{

    /**
     * @var HasRightsVisitor
     */
    private $hasRightsNodeVisitor;

    protected function setUp(): void
    {
        $this->hasRightsNodeVisitor = new HasRightsVisitor();
        parent::setUp();
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extension\HasRightsExtension:leaveNode
     */
    public function testLeaveNode(): void
    {
        $node = $this->getNode();
        $env = $this->getEnv();
        $this->assertEquals($node, $this->hasRightsNodeVisitor->leaveNode($node, $env));
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extension\HasRightsExtension:getPriority
     */
    public function testGetPriority(): void
    {
        $this->assertEquals(0, $this->hasRightsNodeVisitor->getPriority());
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extension\HasRightsExtension:enterNode
     */
    public function testEnterNode(): void
    {
        $node = $this->getNode();
        $env = $this->getEnv();
        $this->assertEquals($node, $this->hasRightsNodeVisitor->enterNode($node, $env));
    }

    /**
     * @return \Twig_Node
     */
    private function getNode(): \Twig_Node
    {
        /** @var \Twig_Node $node */
        $node = $this->getMockBuilder('Twig_Node')->getMock();

        return $node;
    }

    /**
     * @return \Twig_Environment
     */
    private function getEnv(): \Twig_Environment
    {
        $loader = new ArrayLoader(['index' => 'foo']);
        $env = new \Twig_Environment($loader, ['debug' => true, 'cache' => false]);

        return $env;
    }
}
