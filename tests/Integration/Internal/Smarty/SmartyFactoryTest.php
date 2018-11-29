<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Smarty;


use org\bovigo\vfs\vfsStream;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Smarty\SmartyContext;
use OxidEsales\EshopCommunity\Internal\Smarty\SmartyContextInterface;
use OxidEsales\EshopCommunity\Internal\Smarty\SmartyFactory;
use OxidEsales\EshopCommunity\Internal\Smarty\SmartyEngineConfiguration;

class SmartyFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider smartySettingsDataProvider
     *
     * @param bool  $securityMode
     * @param array $smartySettings
     */
    public function testFillSmartyProperties($securityMode, $smartySettings)
    {
        /** @var SmartyContextInterface $smartyContext */
        $smartyContext = $this->getSmartyContext($securityMode);
        $smartyFactory = new SmartyFactory(new SmartyEngineConfiguration($smartyContext));

        $smarty = $smartyFactory->getSmarty();

        foreach ($smartySettings as $varName => $varValue) {
            $this->assertTrue(isset($smarty->$varName), $varName);
            $this->assertEquals($varValue, $smarty->$varName, $varName);
        }
    }

    /**
     * @return array
     */
    public function smartySettingsDataProvider()
    {
        return [
                'security on' => [true, $this->getSmartySettingsWithSecurityOn()],
                'security off' => [false, $this->getSmartySettingsWithSecurityOff()]
        ];
    }

    /**
     * @return array
     */
    private function getSmartySettingsWithSecurityOn()
    {
        $aCheck = [
            'security' => true,
            'php_handling' => SMARTY_PHP_REMOVE,
            'left_delimiter' => '[{',
            'right_delimiter' => '}]',
            'caching' => false,
            'compile_dir' => "testCompileDir",
            'cache_dir' => "testCompileDir",
            'compile_id' => "testCompileId",
            'template_dir' => "testTemplateDir",
            'debugging' => true,
            'compile_check' => true,
            'security_settings' => [
                'PHP_HANDLING' => false,
                'IF_FUNCS' =>
                    [
                        0 => 'array',
                        1 => 'list',
                        2 => 'isset',
                        3 => 'empty',
                        4 => 'count',
                        5 => 'sizeof',
                        6 => 'in_array',
                        7 => 'is_array',
                        8 => 'true',
                        9 => 'false',
                        10 => 'null',
                        11 => 'XML_ELEMENT_NODE',
                        12 => 'is_int',
                    ],
                'INCLUDE_ANY' => false,
                'PHP_TAGS' => false,
                'MODIFIER_FUNCS' =>
                    [
                        0 => 'count',
                        1 => 'round',
                        2 => 'floor',
                        3 => 'trim',
                        4 => 'implode',
                        5 => 'is_array',
                        6 => 'getimagesize',
                    ],
                'ALLOW_CONSTANTS' => true,
                'ALLOW_SUPER_GLOBALS' => true,
            ],
            'plugins_dir' => [
                'testModuleDir',
                'testShopDir',
                'plugins'
            ],
        ];
        return $aCheck;
    }

    /**
     * @return array
     */
    private function getSmartySettingsWithSecurityOff()
    {
        $aCheck = [
            'security' => false,
            'php_handling' => 1,
            'left_delimiter' => '[{',
            'right_delimiter' => '}]',
            'caching' => false,
            'compile_dir' => "testCompileDir",
            'cache_dir' => "testCompileDir",
            'compile_id' => "testCompileId",
            'template_dir' => "testTemplateDir",
            'debugging' => true,
            'compile_check' => true,
            'plugins_dir' => [
                'testModuleDir',
                'testShopDir',
                'plugins'
            ],
        ];
        return $aCheck;
    }

    private function getSmartyContext($securityMode = false)
    {
        $config = $this->getConfigMock($securityMode);
        $utilsView = $this->getUtilsViewMock();

        $smartyContext = new SmartyContext($config, $utilsView);

        return $smartyContext;
    }

    private function getConfigMock($demoShopMode = false)
    {
        $structure = [
            'Smarty' => [
                'Plugin' => 'prefilter.oxblock.php'
            ]
        ];
        $smartyDir = vfsStream::setup('testDir', null, $structure);

        $configMock = $this
            ->getMockBuilder(Config::class)
            ->getMock();

        $configMock->expects($this->at(0))
            ->method('getConfigParam')
            ->with('iDebug')
            ->will($this->returnValue(1));

        $configMock->expects($this->at(1))
            ->method('getConfigParam')
            ->with('blCheckTemplates')
            ->will($this->returnValue(true));

        $configMock->expects($this->at(2))
            ->method('getConfigParam')
            ->with('iSmartyPhpHandling')
            ->will($this->returnValue(true));

        $configMock->expects($this->at(4))
            ->method('getConfigParam')
            ->with('sCoreDir')
            ->will($this->returnValue($smartyDir->url().'Smarty/Plugin'));

        $configMock->expects($this->at(5))
            ->method('getConfigParam')
            ->with('iDebug')
            ->will($this->returnValue(1));

        $configMock->method('isDemoShop')
            ->will($this->returnValue($demoShopMode));

        $configMock->method('isAdmin')
            ->will($this->returnValue(false));

        return $configMock;
    }

    private function getUtilsViewMock()
    {
        $utilsViewMock = $this
            ->getMockBuilder(UtilsView::class)
            ->getMock();

        $utilsViewMock->method('getSmartyDir')
            ->will($this->returnValue('testCompileDir'));

        $utilsViewMock->method('getTemplateDirs')
            ->will($this->returnValue('testTemplateDir'));

        $utilsViewMock->method('getTemplateCompileId')
            ->will($this->returnValue('testCompileId'));

        $utilsViewMock
            ->method('getModuleSmartyPluginDirectories')
            ->willReturn(['testModuleDir']);

        $utilsViewMock
            ->method('getShopSmartyPluginDirectories')
            ->willReturn(['testShopDir']);

        return $utilsViewMock;
    }
}