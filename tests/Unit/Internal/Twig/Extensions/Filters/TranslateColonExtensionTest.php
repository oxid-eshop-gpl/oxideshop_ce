<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Filters;

use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\TranslateColonExtension;
use PHPUnit\Framework\TestCase;

/**
 * Class TranslateColonFilterTest
 *
 * @package OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Filters
 */
class TranslateColonFilterTest extends TestCase
{

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\TranslateColonExtension::getTranslatedColon
     */
    public function testGetTranslatedColon(): void
    {
        $translateColonFilter = new TranslateColonExtension();
        $translatedColon = $translateColonFilter->getTranslatedColon('foo');
        $this->assertEquals('foo:', $translatedColon);
    }
}
