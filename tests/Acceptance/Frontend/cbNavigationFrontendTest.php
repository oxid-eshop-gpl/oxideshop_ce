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
use OxidEsales\TestingLibrary\oxComponents\Domain\CurrencyMenu;
use OxidEsales\TestingLibrary\oxComponents\Domain\CurrencyBox;
use OxidEsales\TestingLibrary\oxComponents\Domain\Footer;
use OxidEsales\TestingLibrary\oxComponents\Domain\Article\ArticlesList;

/** Selenium tests for new layout. */
class cbNavigationFrontendTest extends FrontendTestCase
{
    protected $_blStartMinkSession = false;

    protected $currentMinkDriver = 'selenium2';

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
    public function testFrontendCurrencies3()
    {die();
        $page = $this->openShop();

        //currency checking
        $currencyBox = new CurrencyBox($page);

       /* $this->click("//div[@class='btn-group currencies-menu']/button");
        $this->waitForItemAppear("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[@class='active']//*[text()='EUR']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[2]//*[text()='GBP']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[3]//*[text()='CHF']");
        $this->assertElementPresent("//div[@class='btn-group currencies-menu open']/ul[@class='dropdown-menu dropdown-menu-right']/li[4]//*[text()='USD']");
        $this->assertEquals("50,00 € *", $this->getText("//div[@id='newItems']/div/div[1]//div[@class='price text-center']//span[@class='lead text-nowrap']"));*/

      //  $header->getCurrencyMenu()->click();

        $this->selectCurrency($page, "GBP");
        $this->assertEquals("GBP", $currencyBox->getActiveCurrency());

        $articlesList = new ArticlesList($page, 'boxwrapper_newItems');
        $articleBox = $articlesList->getArticlesListBoxes('newItems')->getArticleBox(1);
        $this->assertEquals("42.83 £ * 2 kg | 21.42 £/kg", $articleBox->getPriceInformation('price text-center'));

        $this->selectCurrency($page, "CHF");
        $this->assertEquals("CHF", $currencyBox->getActiveCurrency());

        $articlesList = new ArticlesList($page, 'boxwrapper_newItems');
        $articleBox = $articlesList->getArticlesListBoxes('newItems')->getArticleBox(1);
        $this->assertEquals("71,63 CHF * 2 kg | 35,82 CHF/kg", $articleBox->getPriceInformation('price text-center'));

        $this->selectCurrency($page, "USD");
        $this->assertEquals("USD", $currencyBox->getActiveCurrency());

        $articlesList = new ArticlesList($page, 'boxwrapper_newItems');
        $articleBox = $articlesList->getArticlesListBoxes('newItems')->getArticleBox(1);
        $this->assertEquals("64.97 $ * 2 kg | 32.49 $/kg", $articleBox->getPriceInformation('price text-center'));

        $this->selectCurrency($page, "EUR");
        $this->assertEquals("EUR", $currencyBox->getActiveCurrency());

        $articlesList = new ArticlesList($page, 'boxwrapper_newItems');
        $articleBox = $articlesList->getArticlesListBoxes('newItems')->getArticleBox(1);
        $this->assertEquals("50,00 € * 2 kg | 25,00 €/kg", $articleBox->getPriceInformation('price text-center'));

        // #1739 currency switch in vendors


        $footer = new Footer($page);
        $footer->clickManufacturerLink('Manufacturer [EN] šÄßüл');
        sleep(1);

        $articlesList = new ArticlesList($page);
        $articleBox = $articlesList->getArticlesListBoxes('productList')->getArticleBox(1);
        $this->assertEquals("Test product 0 [EN] šÄßüл", $articleBox->getTitleLink()->getText());
        $this->assertEquals("50,00 € * 2 kg | 25,00 €/kg", $articleBox->getPriceInformation());

        $this->selectCurrency($page, "GBP");

        $articlesList = new ArticlesList($page);
        $articleBox = $articlesList->getArticlesListBoxes('productList')->getArticleBox(1);
        $this->assertEquals("Test product 0 [EN] šÄßüл", $articleBox->getTitleLink()->getText());
        $this->assertEquals("42.83 £ * 2 kg | 21.42 £/kg", $articleBox->getPriceInformation());

        $this->selectCurrency($page, "EUR");

        $articlesList = new ArticlesList($page);
        $articleBox = $articlesList->getArticlesListBoxes('productList')->getArticleBox(1);
        $this->assertEquals("50,00 € * 2 kg | 25,00 €/kg", $articleBox->getPriceInformation());
    }

    /**
     * Selects shop currency in frontend.
     *
     * @param string $currency Currency title.
     */
    public function selectCurrency($page, $currency)
    {
        $currencyBox = new CurrencyBox($page);
        $currencyBox->openCurrencyMenu();

        $currMenu = new CurrencyMenu($page);
        $currMenu->selectCurrency($currency);

        sleep(1);
    }

}
