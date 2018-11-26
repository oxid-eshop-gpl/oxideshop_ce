<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Filters;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\EncloseExtension;
use PHPUnit\Framework\TestCase;

class EncloseFilterTest extends TestCase
{

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\EncloseExtension::enclose
     */
    public function testEnclose()
    {
        $string = "foo";
        $encloser = "*";
        $encloseFilter = new EncloseExtension();
        $enclosedString = $encloseFilter->enclose($string, $encloser);
        $this->assertEquals('*foo*', $enclosedString);
    }

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\EncloseExtension::enclose
     */
    public function testEncloseNoEncloder()
    {
        $string = "foo";
        $encloseFilter = new EncloseExtension();
        $enclosedString = $encloseFilter->enclose($string);
        $this->assertEquals('foo', $enclosedString);
    }
}
