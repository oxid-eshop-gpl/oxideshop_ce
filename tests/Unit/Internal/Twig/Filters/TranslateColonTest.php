<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Filters;

use OxidEsales\EshopCommunity\Internal\Twig\Filters\TranslateColonFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class TranslateColonFilterTest
 *
 * @package OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Filters
 */
class TranslateColonFilterTest extends TestCase
{

    /**
     * @covers \OxidEsales\EshopCommunity\Internal\Twig\Filters\TranslateColonFilter::getTranslatedColon
     */
    public function testGetTranslatedColon()
    {
        $translateColonFilter = new TranslateColonFilter();
        $translatedColon = $translateColonFilter->getTranslatedColon('foo');
        $this->assertEquals('foo:', $translatedColon);
    }
}
