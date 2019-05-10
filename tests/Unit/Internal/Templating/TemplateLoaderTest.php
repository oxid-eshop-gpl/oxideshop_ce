<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Templating;

use org\bovigo\vfs\vfsStream;
use OxidEsales\EshopCommunity\Internal\Templating\FileLocatorInterface;
use OxidEsales\EshopCommunity\Internal\Templating\TemplateLoader;
use OxidEsales\EshopCommunity\Internal\Templating\TemplateNameResolver;

class TemplateLoaderTest extends \PHPUnit\Framework\TestCase
{
    public function testExists()
    {
        $locator = $this->getFileLocatorMock('test_template.tpl');
        $loader = new TemplateLoader($locator, new TemplateNameResolver());

        $this->assertTrue($loader->exists('test_template.tpl'));
    }

    public function testIfTemplateDoNotExists()
    {
        $locator = $this->getFileLocatorMock(false);
        $loader = new TemplateLoader($locator, new TemplateNameResolver());

        $this->assertFalse($loader->exists('not_existing_template.tpl'));
    }

    public function testGetContext()
    {
        $context = "The new contents of the file";
        $templateDir = vfsStream::setup('testTemplateDir');
        $template = vfsStream::newFile('testSmartyTemplate.tpl')
            ->at($templateDir)
            ->setContent($context)
            ->url();

        $locator = $this->getFileLocatorMock($template);
        $loader = new TemplateLoader($locator, new TemplateNameResolver());

        $this->assertSame($context, $loader->getContext($template));
    }

    /**
     * @param $path
     *
     * @return FileLocatorInterface
     */
    private function getFileLocatorMock($path)
    {
        $locator = $this
            ->getMockBuilder('OxidEsales\EshopCommunity\Internal\Templating\FileLocator')
            ->disableOriginalConstructor()
            ->getMock();

        $locator->expects($this->any())
            ->method('locate')
            ->will($this->returnValue($path));

        return $locator;
    }
}
