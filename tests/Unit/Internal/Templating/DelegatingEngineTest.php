<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Templating;

use OxidEsales\EshopCommunity\Internal\Templating\TraditionalEngine;

class DelegatingEngineTest extends \PHPUnit\Framework\TestCase
{
    public function testRender()
    {
        $response = 'rendered template';
        $engine = $this->getEngineMock();
        $engine->expects($this->once())
            ->method('render')
            ->with('template')
            ->will($this->returnValue($response));
        $resolver = $this->getResolverMock('template');

        $delegatingEngine = new TraditionalEngine($engine, $resolver);

        $this->assertSame($response, $delegatingEngine->renderTemplate('template', []));
    }

    public function testGetExistingEngine()
    {
        $engine = $this->getEngineMock();
        $resolver = $this->getResolverMock('template');

        $delegatingEngine = new TraditionalEngine($engine, $resolver);

        $this->assertSame($engine, $delegatingEngine->getEngine());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No engine was defined.
     */
    public function testNoEngineFound()
    {
        $resolver = $this->getResolverMock('template');
        $delegatingEngine = new TraditionalEngine(null, $resolver);

        $delegatingEngine->getEngine();
    }

    private function getEngineMock()
    {
        $engine = $this
            ->getMockBuilder('OxidEsales\EshopCommunity\Internal\Templating\EngineInterface')
            ->getMock();

        $engine->expects($this->any())
            ->method('getDefaultFileExtension')
            ->will($this->returnValue('tpl'));

        return $engine;
    }

    private function getResolverMock($returnValue)
    {
        $resolver = $this
            ->getMockBuilder('OxidEsales\EshopCommunity\Internal\Templating\TemplateNameResolverInterface')
            ->getMock();

        $resolver->expects($this->any())
            ->method('resolve')
            ->will($this->returnValue($returnValue));
        return $resolver;
    }
}
