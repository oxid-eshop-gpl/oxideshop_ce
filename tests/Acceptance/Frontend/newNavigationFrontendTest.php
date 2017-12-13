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
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

namespace OxidEsales\EshopCommunity\Tests\Acceptance\Frontend;

use OxidEsales\EshopCommunity\Tests\Acceptance\FrontendTestCase;

/** Selenium tests for new layout. */
class newNavigationFrontendTest extends FrontendTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->callShopSC("oxConfig", null, null, array(
            "sTheme" => array(
                "type" => "str",
                "value" => 'flow'
            )
        ));
    }
    /**
     * switching currencies in frontend
     *
     * @group main
     */
    public function testFrontendCurrencies2()
    {
        $this->openShop();

        //currency checking
        $this->click("//div[@class='btn-group currencies-menu']/button");
        $this->waitForItemAppear("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[@class='active']//*[text()='EUR']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[2]//*[text()='GBP']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[3]//*[text()='CHF']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[4]//*[text()='USD']");
        $this->assertEquals("50,00 € *", $this->getText("//div[@id='newItems']/div/div[1]//div[@class='price text-center']//span[@class='lead text-nowrap']"));

        $this->clickAndWait("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[2]/a");
        $this->assertElementNotVisible("//div[@class='btn-group currencies-menu open']");
        $this->assertEquals("GBP", $this->getText("//div[@class='btn-group currencies-menu']/button"));
        $this->assertEquals("42.83 £ *", $this->getText("//div[@id='newItems']/div/div[1]//div[@class='price text-center']//span[@class='lead text-nowrap']"));

        $this->switchCurrency("CHF");
        $this->assertEquals("CHF", $this->getText("//div[@class='btn-group currencies-menu']/button"));
        $this->assertEquals("71,63 CHF *", $this->getText("//div[@id='newItems']/div/div[1]//div[@class='price text-center']//span[@class='lead text-nowrap']"));

        $this->switchCurrency("USD");
        $this->assertEquals("USD", $this->getText("//div[@class='btn-group currencies-menu']/button"));
        $this->assertEquals("64.97 $ *", $this->getText("//div[@id='newItems']/div/div[1]//div[@class='price text-center']//span[@class='lead text-nowrap']"));

        $this->switchCurrency("EUR");
        $this->assertEquals("EUR", $this->getText("//div[@class='btn-group currencies-menu']/button"));
        $this->assertEquals("50,00 € *", $this->getText("//div[@id='newItems']/div/div[1]//div[@class='price text-center']//span[@class='lead text-nowrap']"));

        $this->clickAndWait("link=Test category 0 [EN] šÄßüл");
        $this->assertEquals("50,00 € *", $this->getText("//div[@id='productList']/div/div[1]//span[@class='lead text-nowrap']"));

        // #1739 currency switch in vendors
        $this->clickAndWait("link=Manufacturer [EN] šÄßüл");
        $this->assertEquals("Test product 0 [EN] šÄßüл", $this->getText("//a[@id='productList_1']/span"));
        $this->assertEquals("50,00 € *", $this->getText("//div[@id='productList']/div/div[1]//span[@class='lead text-nowrap']"));

        $this->switchCurrency("GBP");
        $this->assertEquals("Test product 0 [EN] šÄßüл", $this->getText("//a[@id='productList_1']/span"));
        $this->assertEquals("42.83 £ *", $this->getText("//div[@id='productList']/div/div[1]//span[@class='lead text-nowrap']"));

        $this->switchCurrency("EUR");
        $this->assertEquals("Test product 0 [EN] šÄßüл", $this->getText("//a[@id='productList_1']/span"));
        $this->assertEquals("50,00 € *", $this->getText("//div[@id='productList']/div/div[1]//span[@class='lead text-nowrap']"));
    }

    /**
     * Selects shop currency in frontend.
     *
     * @param string $currency Currency title.
     */
    public function switchCurrency($currency)
    {
        $this->click("//div[@class='btn-group currencies-menu']/button");
        $this->waitForItemAppear("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']");
        $this->clickAndWait("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']//*[text()='$currency']");
    }

}
