<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Templating;

use OxidEsales\EshopCommunity\Internal\Templating\DelegatingEngine;

class DelegatingEngineTest extends \PHPUnit\Framework\TestCase
{
    public function testRender()
    {
        $response = 'rendered template';
        $engine = $this->getEngineMock([['template.tpl', true]]);
        $engine->expects($this->once())
            ->method('render')
            ->with('template.tpl')
            ->will($this->returnValue($response));

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine]);

        $this->assertSame($response, $delegatingEngine->render('template.tpl'));
    }

    public function testSupportsOneEngine()
    {
        $engine = $this->getEngineMock([['template.tpl', true]]);

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine]);

        $this->assertTrue($delegatingEngine->supports('template.tpl'));
    }

    public function testDoNotSupportedEngine()
    {
        $engine = $this->getEngineMock([['template.twig', false]]);

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine]);

        $this->assertFalse($delegatingEngine->supports('template.twig'));
    }

    public function testSupportsTwoEngines()
    {
        $engine1 = $this->getEngineMock([['template.tpl', true], ['template.twig', false]]);

        $engine2 = $this->getEngineMock([['template.twig', true]]);

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine1, 'twig' => $engine2]);

        $this->assertTrue($delegatingEngine->supports('template.tpl'));
        $this->assertTrue($delegatingEngine->supports('template.twig'));
    }

    public function testGetExistingEngine()
    {
        $engine1 = $this->getEngineMock([['template.twig', false]]);

        $engine2 = $this->getEngineMock([['template.twig', true]]);

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine1, 'twig' => $engine2]);

        $this->assertSame($engine2, $delegatingEngine->getEngine('template.twig'));
    }

    public function testAddSecondEngine()
    {
        $engine1 = $this->getEngineMock([['template.twig', false]]);

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine1]);

        $engine2 = $this->getEngineMock([['template.twig', true]]);

        $delegatingEngine->addEngine($engine2);

        $this->assertSame($engine2, $delegatingEngine->getEngine('template.twig'));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No engine is able to work with the template "template.php"
     */
    public function testGetInvalidEngine()
    {
        $engine = $this->getEngineMock([['template.php', false]]);

        $delegatingEngine = new DelegatingEngine(['smarty' => $engine]);

        $delegatingEngine->getEngine('template.php');
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No engine is able to work with the template "template.php"
     */
    public function testNoEngineFound()
    {
        $delegatingEngine = new DelegatingEngine();

        $delegatingEngine->getEngine('template.php');
    }

    public function testAddFallBackEngine()
    {
        $engine = $this->getEngineMock([['template.tpl', true]]);

        $delegatingEngine = new DelegatingEngine();
        $delegatingEngine->addFallBackEngine($engine);

        $this->assertSame($engine, $delegatingEngine->getEngine());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No engine was defined.
     */
    public function testNoEngineGiven()
    {
        $delegatingEngine = new DelegatingEngine();

        $delegatingEngine->getEngine();
    }

    private function getEngineMock($returnValue)
    {
        $engine = $this->getMockBuilder('OxidEsales\EshopCommunity\Internal\Templating\BaseEngineInterface')->getMock();

        $engine->expects($this->any())
            ->method('supports')
            ->will($this->returnValueMap($returnValue));

        return $engine;
    }
}
