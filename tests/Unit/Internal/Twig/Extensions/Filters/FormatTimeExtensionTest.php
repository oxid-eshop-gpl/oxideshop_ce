<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatTimeLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\FormatTimeExtension;
use PHPUnit\Framework\TestCase;

class FormatTimeExtensionTest extends TestCase
{

    public function provider()
    {
        return [
            [0, '00:00:00'],
            [77834, '21:37:14'],
            [460800, '128:00:00']
        ];
    }

    /**
     * @param int $seconds
     * @param string $expectedTime
     *
     * @dataProvider provider
     */
    public function testFormatTime($seconds, $expectedTime)
    {
        $formatTimeLogic = new FormatTimeLogic();
        $formatTimeExtension = new FormatTimeExtension($formatTimeLogic);
        $formattedTime = $formatTimeExtension->formatTime($seconds);
        $this->assertEquals($expectedTime, $formattedTime);
    }

    public function incorrectDataProvider()
    {
        return [
            ['error']
        ];
    }

    /**
     * @param int $seconds
     *
     * @dataProvider incorrectDataProvider
     * @expectedException \Twig_Error
     */
    public function testFormatTimeError($seconds)
    {
        $formatTimeLogic = new FormatTimeLogic();
        $formatTimeExtension = new FormatTimeExtension($formatTimeLogic);
        $formatTimeExtension->formatTime($seconds);
    }


}
