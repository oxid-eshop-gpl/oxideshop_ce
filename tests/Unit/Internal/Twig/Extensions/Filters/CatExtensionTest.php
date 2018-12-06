<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Filters;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\CatExtension;
use PHPUnit\Framework\TestCase;

class CatExtensionTest extends TestCase
{

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\CatExtension::cat
     */
    public function testCat(): void
    {
        $catFilter = new CatExtension();
        $string = 'foo';
        $cat = 'bar';
        $actual = $catFilter->cat($string, $cat);
        $this->assertEquals($string . $cat, $actual);
    }
}
