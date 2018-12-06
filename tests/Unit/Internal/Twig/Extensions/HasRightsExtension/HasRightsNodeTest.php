<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\HasRightsExtension;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsNode;
use PHPUnit\Framework\TestCase;
use Twig\Loader\ArrayLoader;

class HasRightsNodeTest extends TestCase
{

    /**
     * @var HasRightsNode
     */
    private $hasRightsNode;

    protected function setUp(): void
    {
        $data = 'foo';
        $params = new \Twig_Node_Text($data, 0);
        $params->setNode(0, new \Twig_Node_Text('foo, bar', 0));
        $this->hasRightsNode = new HasRightsNode($params);
        parent::setUp();
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension\HasRightsNode:compile
     */
    public function testCompile(): void
    {
        $env = $this->getEnv();
        $compiler = new \Twig_Compiler($env);
        $this->hasRightsNode->compile($compiler);
        $this->assertEquals('echo "foo, bar";' . PHP_EOL, $compiler->getSource());
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
