<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2017
 * @version   OXID eShop CE
 */
namespace Unit\Application\Component\Widget;

/**
 * Tests for SuggestUrlBuilder.
 */
class SuggestUrlBuilderTest extends \OxidEsales\TestingLibrary\UnitTestCase
{
    /**
     * The data provider for the test testBuildUrl.
     *
     * @return array The test cases.
     */
    public function dataProviderTestBuildUrl()
    {
        return array(
            array(
                'requestParams' => array(),
                'expectedResult' => ''
            ),
            array(
                'requestParams' => array(
                    'searchparam' => true
                ),
                'expectedResult' => '&searchparam=true'
            )
        );
    }

    /**
     * Test, that the method buildUrl works as expected
     *
     * @dataProvider dataProviderTestBuildUrl
     */
    public function testBuildUrl($requestParams, $expectedResult)
    {
        foreach ($requestParams as $requestKey => $requestValue) {
            $this->setRequestParameter($requestKey, $requestValue);
        }

        $suggestUrlBuilder = oxNew(\OxidEsales\Eshop\Application\Component\SuggestUrlBuilder::class);

        $this->assertEquals($expectedResult, $suggestUrlBuilder->buildUrl());
    }
}
